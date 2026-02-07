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
 * view.php
 *
 * @package   mod_scicalc
 * @copyright 2026 Eduardo Kraus {@link https://eduardokraus.com}
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

use mod_scicalc\event\course_module_viewed;

require_once(__DIR__ . "/../../config.php");
require_once(__DIR__ . "/lib.php");

$id = required_param("id", PARAM_INT);

$cm = get_coursemodule_from_id("scicalc", $id, 0, false, MUST_EXIST);
$course = get_course($cm->course);
$scicalc = $DB->get_record("scicalc", ["id" => $cm->instance], "*", MUST_EXIST);

require_course_login($course, true, $cm);

$context = context_module::instance($cm->id);
require_capability("mod/scicalc:view", $context);

$PAGE->set_url(new moodle_url("/mod/scicalc/view.php", ["id" => $cm->id]));
$PAGE->set_title(format_string($scicalc->name));
$PAGE->set_heading(format_string($course->fullname));
$PAGE->set_context($context);

$event = course_module_viewed::create([
    "objectid" => $scicalc->id,
    "context" => $context,
]);
$event->add_record_snapshot("course", $course);
$event->add_record_snapshot("scicalc", $scicalc);
$event->trigger();

$PAGE->requires->js_call_amd("mod_scicalc/calculator", "init", [$cm->id]);
echo $OUTPUT->header();

$data = (object) [
    "intro" => format_module_intro("scicalc", $scicalc, $cm->id),
    "cmid" => $cm->id,
];
echo $OUTPUT->render_from_template("mod_scicalc/view", $data);

echo $OUTPUT->footer();
