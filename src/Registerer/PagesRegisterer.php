<?php

namespace Rezfusion\Registerer;

use Rezfusion\Actions;
use Rezfusion\Controller\ReviewController;
use Rezfusion\Helper\AssetsRegistererInterface;
use Rezfusion\Pages\Admin\CategoryInfoPage;
use Rezfusion\Pages\Admin\ConfigurationPage;
use Rezfusion\Pages\Admin\HubConfigurationPage;
use Rezfusion\Pages\Admin\ItemInfoPage;
use Rezfusion\Pages\Admin\ReviewsListPage;
use Rezfusion\Plugin;
use Rezfusion\Template;
use Rezfusion\Templates;
use Rezfusion\UserRoles;

class PagesRegisterer implements RegistererInterface
{
    /**
     * @var AssetsRegistererInterface
     */
    private $AssetsRegisterer;

    /**
     * @param AssetsRegistererInterface $AssetsRegisterer
     */
    public function __construct(AssetsRegistererInterface $AssetsRegisterer)
    {
        $this->AssetsRegisterer = $AssetsRegisterer;
    }

    /**
     * Enqueue scripts and styles for configuration page.
     * 
     * @return void
     */
    private function enqueueConfigurationPageScripts(): void
    {
        add_action(Actions::adminEnqueueScripts(), function () {
            // @codeCoverageIgnoreStart
            $pageName = @$_GET['page'];
            if ($pageName === ConfigurationPage::pageName()) {
                $currentTab = @$_GET['tab'];
                if ($currentTab === ConfigurationPage::generalTabName() || empty($currentTab)) {
                    $this->AssetsRegisterer->handleScript('configuration-page-validation.js', [], false, true);
                    $this->AssetsRegisterer->handleScript('configuration-general-handler.js', [], false, true);
                } else if ($currentTab === ConfigurationPage::floorPlanTabName()) {
                    $this->AssetsRegisterer->handleStyle('rezfusion.css', [], false, false);
                }
            } else if ($pageName === ReviewsListPage::pageName()) {
                $this->AssetsRegisterer->handleScript('rezfusion-table.js', [], false, true);
                $this->AssetsRegisterer->handleScript('configuration-reviews-list-view-handler.js', [], false, true);
            }
            // @codeCoverageIgnoreEnd
        });
    }

    /**
     * Prepares "Reviews List" menu item.
     * 
     * If user is not an administrator then it adds separate menu item,
     * otherwise it will be added as sub-item.
     * 
     * @param string $menuPageId
     */
    private function prepareReviewsMenuItem($menuPageId = ''): void
    {
        if (is_user_logged_in()) {
            $currentUser = wp_get_current_user();
            $allowedUserRoles = ReviewController::getAllowedUserRoles();
            if (UserRoles::userHasAnyRole($currentUser, $allowedUserRoles)) {
                $function = 'add_submenu_page';
                $name = 'Reviews List';
                $parameters = [
                    !UserRoles::userHasRoles($currentUser, [UserRoles::administrator()]) ? '' : $menuPageId,
                    $name,
                    $name,
                    UserRoles::userHasRoles($currentUser, [UserRoles::administrator()]) ? UserRoles::administrator() : $currentUser->roles[0],
                    ReviewsListPage::pageName(),
                    [new ReviewsListPage(new Template(Templates::reviewsListPage())), 'display']
                ];
                if (empty($parameters[0])) {
                    array_shift($parameters);
                    $function = 'add_menu_page';
                }
                call_user_func_array($function, $parameters);
            }
        }
    }

    /**
     * @inheritdoc
     */
    public function register(): void
    {
        $this->enqueueConfigurationPageScripts();

        add_action(Actions::adminMenu(), function () {
            $menuName = 'rezfusion_components_config';
            $userRole = UserRoles::administrator();

            add_menu_page(
                Plugin::getInstance()->getPluginName() . ' Components',
                Plugin::getInstance()->getPluginName(),
                $userRole,
                $menuName,
                [new ConfigurationPage(new Template(Templates::configurationPageTemplate())), 'display']
            );

            // Rezfusion Hub Configuration page.
            add_submenu_page(
                $menuName,
                'Hub Configuration',
                'Hub Configuration',
                'administrator',
                HubConfigurationPage::pageName(),
                [new HubConfigurationPage(new Template(Templates::hubConfigurationTemplate())), 'display']
            );

            add_submenu_page(
                $menuName,
                'Items',
                'Items',
                $userRole,
                ItemInfoPage::pageName(),
                [new ItemInfoPage(new Template(Templates::itemsConfigurationPageTemplate())), 'display']
            );

            add_submenu_page(
                $menuName,
                'Categories',
                'Categories',
                $userRole,
                CategoryInfoPage::pageName(),
                [new CategoryInfoPage(new Template(Templates::categoriesConfigurationPageTemplate())), 'display']
            );

            $this->prepareReviewsMenuItem($menuName);
        });
    }
}
