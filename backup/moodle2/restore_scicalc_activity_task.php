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
 * Restore task for the scicalc activity.
 *
 * @package   mod_scicalc
 * @copyright 2026 Eduardo Kraus {@link https://eduardokraus.com}
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class restore_scicalc_activity_task extends restore_activity_task {

    /**
     * No special settings for this activity.
     */
    protected function define_my_settings() {
        // No settings.
    }

    /**
     * Defines restore steps for this activity.
     */
    protected function define_my_steps() {
        $this->add_step(new restore_scicalc_activity_structure_step("scicalc_structure", "scicalc.xml"));
    }

    /**
     * Defines content to be decoded (intro).
     *
     * @return restore_decode_content[]
     */
    public static function define_decode_contents() {
        return [
            new restore_decode_content("scicalc", ["intro"], "scicalc"),
        ];
    }

    /**
     * Defines link decode rules.
     *
     * @return restore_decode_rule[]
     */
    public static function define_decode_rules() {
        return [
            new restore_decode_rule("SCICALCINDEX", "/mod/scicalc/index.php?id=$1", "course"),
            new restore_decode_rule("SCICALCVIEWBYID", "/mod/scicalc/view.php?id=$1", "course_module"),
        ];
    }

    /**
     * Defines restore log rules.
     *
     * @return restore_log_rule[]
     */
    public static function define_restore_log_rules() {
        return [
            new restore_log_rule("scicalc", "view", "view.php?id={course_module}", "{scicalc}"),
            new restore_log_rule("scicalc", "add", "view.php?id={course_module}", "{scicalc}"),
            new restore_log_rule("scicalc", "update", "view.php?id={course_module}", "{scicalc}"),
        ];
    }

    /**
     * Defines restore log rules for course level actions.
     *
     * @return restore_log_rule[]
     */
    public static function define_restore_log_rules_for_course() {
        return [
            new restore_log_rule("scicalc", "view all", "index.php?id={course}", null),
        ];
    }
}
