<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * mobile.php
 *
 * @package   mod_scicalc
 * @copyright 2026 Eduardo Kraus {@link https://eduardokraus.com}
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace mod_scicalc\external;

use completion_info;
use context_module;
use core_external\restricted_context_exception;
use external_api;
use external_function_parameters;
use external_single_structure;
use external_value;
use mod_scicalc\event\course_module_viewed;

defined('MOODLE_INTERNAL') || die();

require_once("{$CFG->libdir}/externallib.php");
require_once("{$CFG->libdir}/completionlib.php");

/**
 * External service used by the custom mobile app when a scientific calculator is opened.
 */
class mobile extends external_api {

    /**
     * Service parameters.
     *
     * @return external_function_parameters
     */
    public static function execute_parameters(): external_function_parameters {
        return new external_function_parameters([
            "cmid" => new external_value(PARAM_INT, "Course module id"),
        ]);
    }

    /**
     * Registers the activity view and updates view-based completion.
     *
     * @param int $cmid Course module id.
     * @return array
     * @throws \coding_exception
     * @throws restricted_context_exception
     * @throws \dml_exception
     * @throws \invalid_parameter_exception
     * @throws \required_capability_exception
     */
    public static function execute(int $cmid): array {
        global $DB;

        $params = self::validate_parameters(self::execute_parameters(), [
            "cmid" => $cmid,
        ]);

        $cm = get_coursemodule_from_id("scicalc", $params["cmid"], 0, false, MUST_EXIST);
        $course = get_course($cm->course);
        $context = context_module::instance($cm->id);

        self::validate_context($context);
        require_capability("mod/scicalc:view", $context);

        $scicalc = $DB->get_record("scicalc", ["id" => $cm->instance], "*", MUST_EXIST);

        $event = course_module_viewed::create([
            "objectid" => $scicalc->id,
            "context" => $context,
        ]);
        $event->add_record_snapshot("course", $course);
        $event->add_record_snapshot("scicalc", $scicalc);
        $event->trigger();

        $completion = new completion_info($course);
        $completion->set_module_viewed($cm);

        return [
            "status" => true,
        ];
    }

    /**
     * Service return structure.
     *
     * @return external_single_structure
     */
    public static function execute_returns(): external_single_structure {
        return new external_single_structure([
            "status" => new external_value(PARAM_BOOL, "Whether the activity view was registered"),
        ]);
    }
}
