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
 * Restore structure step for scicalc activity.
 *
 * @package   mod_scicalc
 * @copyright 2026 Eduardo Kraus {@link https://eduardokraus.com}
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class restore_scicalc_activity_structure_step extends restore_activity_structure_step {

    /**
     * Defines the paths to be processed during restore.
     *
     * @return restore_path_element[]
     */
    protected function define_structure() {
        return [
            new restore_path_element("scicalc", "/activity/scicalc"),
        ];
    }

    /**
     * Processes a restored scicalc instance.
     *
     * @param array $data The data from the backup file.
     * @throws dml_exception
     */
    protected function process_scicalc($data) {
        global $DB;

        $data = (object) $data;

        // Set the course to the current course being restored into.
        $data->course = $this->get_courseid();

        // Insert the new instance.
        $newitemid = $DB->insert_record("scicalc", $data);

        // Map old instance id to new one.
        $this->apply_activity_instance($newitemid);
    }

    /**
     * After execute: add related files.
     */
    protected function after_execute() {
        // Add intro files (no itemid).
        $this->add_related_files("mod_scicalc", "intro", null);
    }
}
