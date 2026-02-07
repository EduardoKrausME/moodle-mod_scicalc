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
 * mod_form.php
 *
 * @package   mod_scicalc
 * @copyright 2026 Eduardo Kraus {@link https://eduardokraus.com}
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

// phpcs:disable moodle.Files.MoodleInternal.MoodleInternalGlobalState
require_once($CFG->dirroot . "/course/moodleform_mod.php");

/**
 * Module settings form.
 */
class mod_scicalc_mod_form extends moodleform_mod {

    /**
     * Defines the activity settings form.
     */
    public function definition() {
        $mform = $this->_form;

        $mform->addElement("text", "name", get_string("name"), ["size" => "64"]);
        $mform->setType("name", PARAM_TEXT);
        $mform->addRule("name", null, "required", null, "client");
        $mform->addRule("name", null, "maxlength", 255, "client");

        $this->standard_intro_elements(get_string("intro", "scicalc"));

        $this->standard_coursemodule_elements();
        $this->add_action_buttons();
    }
}
