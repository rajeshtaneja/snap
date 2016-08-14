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
     * Click link in navigation tree that matches the text in parentnode/s (seperated using greater-than character if more than one)
     *
     * @throws ExpectationException
     * @param string $nodetext navigation node to click.
     * @param string $parentnodes comma seperated list of parent nodes.
     * @return void
     */
    public function i_navigate_to_node_in($nodetext, $parentnodes) {
        $this->resize_window('large');
        $this->execute("behat_general::i_click_on", array('#fixy-close', 'css_element'));

        $this->execute('behat_general::click_link', 'admin-menu-trigger');

        parent::i_navigate_to_node_in($nodetext, $parentnodes);
        $this->resize_window('medium');
    }

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
            $this->execute("behat_general::click_link", $nodetext);
        }
    }
}