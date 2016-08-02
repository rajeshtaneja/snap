<?php

/**
 * Log in log out steps definitions.
 *
 * @package    core_auth
 * @category   test
 * @copyright  2012 David Monllaó
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once(__DIR__ . '/../../../../../auth/tests/behat/behat_auth.php');

class behat_theme_snap_behat_auth extends behat_auth {

    public function i_log_in_as($username) {
        $session = $this->getSession();

        // If username is seperated by :: then use second part for keeping the menu open.
        $values = explode("::", $username);

        // Go back to front page.
        $session->visit($this->locate_path('/'));

        if ($this->running_javascript()) {
            // Wait for the homepage to be ready.
            $session->wait(self::TIMEOUT * 1000, self::PAGE_READY_JS);
        }

        /** @var behat_general $general */
        $general = behat_context_helper::get('behat_general');
        $general->i_click_on(get_string('login'), 'link');
        $general->assert_page_not_contains_text(get_string('logout'));

        /** @var behat_forms $form */
        $form = behat_context_helper::get('behat_forms');
        $form->i_set_the_field_to(get_string('username'), $this->escape($values[0]));
        $form->i_set_the_field_to(get_string('password'), $this->escape($values[0]));
        $form->press_button(get_string('login'));

        if (empty($values[1])) {
            $showfixyonlogin = get_config('theme_snap', 'personalmenulogintoggle');
            if ($showfixyonlogin) {
                $general->i_click_on('#fixy-close', 'css_element');
            }
        }
    }
}