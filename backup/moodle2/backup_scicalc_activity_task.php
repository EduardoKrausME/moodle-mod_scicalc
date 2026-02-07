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
 * Backup task for the scicalc activity.
 *
 * @package   mod_scicalc
 * @copyright 2026 Eduardo Kraus {@link https://eduardokraus.com}
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class backup_scicalc_activity_task extends backup_activity_task {

    /**
     * No special settings for this activity.
     */
    protected function define_my_settings() {
        // No settings.
    }

    /**
     * Defines backup steps for this activity.
     */
    protected function define_my_steps() {
        $this->add_step(new backup_scicalc_activity_structure_step("scicalc_structure", "scicalc.xml"));
    }

    /**
     * Encodes content links in the activity intro.
     *
     * @param string $content The content to encode.
     * @return string
     */
    public static function encode_content_links($content): string {
        global $CFG;

        $base = preg_quote($CFG->wwwroot, "/");

        // Link to the index of scicalc in a course.
        $pattern = "/({$base}\\/mod\\/scicalc\\/index\\.php\\?id=)([0-9]+)/";
        $content = preg_replace($pattern, "\$@SCICALCINDEX*\$2@\$", $content);

        // Link to a specific scicalc view by course module id.
        $pattern = "/({$base}\\/mod\\/scicalc\\/view\\.php\\?id=)([0-9]+)/";
        $content = preg_replace($pattern, "\$@SCICALCVIEWBYID*\$2@\$", $content);

        return $content;
    }
}
