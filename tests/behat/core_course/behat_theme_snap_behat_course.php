<?php
require_once(__DIR__ . '/../../../../../course/tests/behat/behat_course.php');

class behat_theme_snap_behat_course extends behat_course {
    /**
     * Opens the activity chooser and opens the activity/resource form page. Sections 0 and 1 are also allowed on frontpage.
     *
     * @throws ElementNotFoundException Thrown by behat_base::find
     * @param string $activity
     * @param int $section
     */
    public function i_add_to_section($activity, $section) {

        if ($this->getSession()->getPage()->find('css', 'body#page-site-index') && (int)$section <= 1) {
            // We are on the frontpage.
            if ($section) {
                // Section 1 represents the contents on the frontpage.
                $sectionxpath = "//body[@id='page-site-index']/descendant::div[contains(concat(' ',normalize-space(@class),' '),' sitetopic ')]";
            } else {
                // Section 0 represents "Site main menu" block.
                $sectionxpath = "//div[contains(concat(' ',normalize-space(@class),' '),' block_site_main_menu ')]";
            }
        } else {
            // We are inside the course.
            $sectionxpath = "//li/a[./@href[contains(normalize-space(.), 'section-" . $section . "')]]";
        }

        $activityliteral = behat_context_helper::escape(ucfirst($activity));

        if ($this->running_javascript()) {

            // Clicks add activity or resource section link.
            $sectionnode = $this->find('xpath', $sectionxpath);
            $sectionnode->click();
            $this->execute('behat_general::click_link', 'Create learning activity or resource');

            // Clicks the selected activity if it exists.
            $activityxpath = "//div[@id='chooseform']/descendant::label" .
                "/descendant::span[contains(concat(' ', normalize-space(@class), ' '), ' typename ')]" .
                "[normalize-space(.)=$activityliteral]" .
                "/parent::label/child::input";
            $activitynode = $this->find('xpath', $activityxpath);
            $activitynode->doubleClick();

        } else {
            // Without Javascript.

            // Selecting the option from the select box which contains the option.
            $selectxpath = $sectionxpath . "/descendant::div[contains(concat(' ', normalize-space(@class), ' '), ' section_add_menus ')]" .
                "/descendant::select[option[normalize-space(.)=$activityliteral]]";
            $selectnode = $this->find('xpath', $selectxpath);
            $selectnode->selectOption($activity);

            // Go button.
            $gobuttonxpath = $selectxpath . "/ancestor::form/descendant::input[@type='submit']";
            $gobutton = $this->find('xpath', $gobuttonxpath);
            $gobutton->click();
        }

    }
}