<?php

/**
 * Log in log out steps definitions.
 *
 * @package    core_auth
 * @category   test
 * @copyright  2012 David Monllaó
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once(__DIR__ . '/../../../../../lib/tests/behat/behat_navigation.php');

class behat_theme_snap_behat_navigation extends behat_navigation {

    /**
     * Click on an entry in the user menu.
     *
     * @param string $nodetext
     */
    public function i_follow_in_the_user_menu($nodetext) {

        if ($this->running_javascript()) {
            $this->execute("behat_general::i_click_on", array('img.userpicture', "css_element"));
        }
        $this->execute("behat_general::click_link", array("View your profile"));

        if ($nodetext !== "Profile") {
            $this->execute("behat_general::click_link", array($nodetext));
        }
    }
}