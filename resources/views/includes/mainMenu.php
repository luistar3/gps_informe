<div class="main-menu-content">
    <ul class="main-navigation">
        <li class="more-details">
            <a href="user-profile.html"><i class="ti-user"></i>View Profile</a>
            <a href="#!"><i class="ti-settings"></i>Settings</a>
            <a href="#!"><i class="ti-layout-sidebar-left"></i>Logout</a>
        </li>
        <?php if ($_SESSION['sesionNombreRol']!="CLIENTE"){ ?>
        <li class="nav-title" data-i18n="nav.category.navigation">
            <i class="ti-line-dashed"></i>
            <span>Administrativo</span>
        </li>
        <?php if (in_array("INICIO", $menuModulosPermisos)) { ?>
            <?php $menu = array('PANEL_ADMIN','PANEL_CLIENTE'); ?>
            <li class="nav-item <?php if (in_array($menuActivo, $menu)) {
                                    echo ('has-class');
                                } ?> ">
                <a href="#!">
                    <i class="ti-home"></i>
                    <span data-i18n="nav.dash.main">INICIO</span>
                </a>
                <ul class="tree-1 <?php if (in_array($menuActivo, $menu)) echo ('has-class'); ?>">
                    <li class=" <?php if ($menuActivo == 'PANEL_ADMIN') echo ('has-class'); ?>">
                        <a href="/gps/src/private/views/viewInicial/clienteView.php" data-i18n="nav.dash.default"> PANEL ADMINISTRATIVO </a>
                    </li>
                </ul>
            </li>
        <?php } ?>
        <?php if (in_array("CONTRATO", $menuModulosPermisos)) { ?>
            <?php $menu = array('NUEVOCONTRATO', 'LISTADOCONTRATO'); ?>
            <li class="nav-item <?php if (in_array($menuActivo, $menu)) {
                                    echo ('has-class');
                                } ?> ">
                <a href="#!">
                    <i class="ti-home"></i>
                    <span data-i18n="nav.dash.main">Contratos</span>
                </a>
                <ul class="tree-1 <?php if ($menuActivo == 'NUEVOCONTRATO') echo ('has-class'); ?>">
                    <li class=" <?php if ($menuActivo == 'NUEVOCONTRATO') echo ('has-class'); ?>">
                        <a href="/gps/src/private/views/contrato/contratoView.php" data-i18n="nav.dash.default"> Nuevo Contrato </a>
                    </li>
                    <li class=" <?php if ($menuActivo == 'LISTADOCONTRATO') echo ('has-class'); ?>">
                        <a href="/gps/src/private/views/contrato/listadoContratoView.php" data-i18n="nav.dash.default"> Listado de Contratos </a>
                    </li>

                </ul>
            </li>
        <?php } ?>

        <?php if (in_array("VEHICULO", $menuModulosPermisos)) { ?>
            <?php $menu = array('GESTION', 'REPORTE'); ?>
            <li class="nav-item <?php if (in_array($menuActivo, $menu)) {
                                    echo ('has-class');
                                } ?> ">
                <a href="#!">
                    <i class="ti-car"></i>
                    <span data-i18n="nav.dash.main">Vehículos</span>
                </a>
                <ul class="tree-1 <?php if ($menuActivo == 'GESTION') echo ('has-class'); ?>">
                    <li class=" <?php if ($menuActivo == 'GESTION') echo ('has-class'); ?>">
                        <a href="/gps/src/private/views/vehiculo/vehiculoView.php" data-i18n="nav.dash.default"> Gestionar vehículos </a>
                    </li>
                    <li class=" <?php if ($menuActivo == 'REPORTE') echo ('has-class'); ?>">
                        <a href="/gps/src/private/views/vehiculo/reporteView.php" data-i18n="nav.dash.default"> Reporte vehículos </a>
                    </li>

                </ul>
            </li>
        <?php } ?>

        <?php if (in_array("CLIENTE", $menuModulosPermisos)) { ?>
            <?php $menu = array('GESTIONCLIENTE', 'REPORTECLIENTE', ''); ?>
            <li class="nav-item <?php if (in_array($menuActivo, $menu)) {
                                    echo ('has-class');
                                } ?> ">
                <a href="#!">
                    <i class="ti-id-badge"></i>
                    <span data-i18n="nav.dash.main">Clientes</span>
                </a>
                <ul class="tree-1 <?php if ($menuActivo == 'GESTION') echo ('has-class'); ?>">
                    <li class=" <?php if ($menuActivo == 'GESTION') echo ('has-class'); ?>">
                        <a href="/gps/src/private/views/cliente/clienteView.php" data-i18n="nav.dash.default"> Gestionar Clientes </a>
                    </li>                  
                </ul>
            </li>
        <?php } ?>
        <?php if (in_array("PERSONA", $menuModulosPermisos)) { ?>
            <?php $menu = array('GESTION', 'REPORTE', 'PERSONANATURALJURIDICA'); ?>
            <li class="nav-item <?php if (in_array($menuActivo, $menu)) {
                                    echo ('has-class');
                                } ?> ">
                <a href="#!">
                    <i class="ti-id-badge"></i>
                    <span data-i18n="nav.dash.main">Personas</span>
                </a>
                <ul class="tree-1 <?php if ($menuActivo == 'PERSONANATURALJURIDICA') echo ('has-class'); ?>">
                    <li class=" <?php if ($menuActivo == 'PERSONANATURALJURIDICA') echo ('has-class'); ?>">
                        <a href="/gps/src/private/views/persona/naturalJuridicaView.php" data-i18n="nav.dash.default">Gestión P. Natural / Jurídica </a>
                    </li>
                    <li class=" <?php if ($menuActivo == 'REPORTE') echo ('has-class'); ?>">
                        <a href="/gps/src/private/views/persona/reporteView.php" data-i18n="nav.dash.default"> Reporte</a>
                    </li>

                </ul>
            </li>
        <?php } ?>
        <?php if (in_array("USUARIO", $menuModulosPermisos)) { ?>
            <?php $menu = array('MODULO_USUARIO_GESTION'); ?>
            <li class="nav-item <?php if (in_array($menuActivo, $menu)) {
                                    echo ('has-class');
                                } ?> ">
                <a href="#!">
                    <i class="ti-id-badge"></i>
                    <span data-i18n="nav.dash.main">Usuarios</span>
                </a>
                <ul class="tree-1 <?php if (in_array($menuActivo, $menu)) echo ('has-class'); ?>">
                    <li class=" <?php if ($menuActivo == 'MODULO_USUARIO_GESTION') echo ('has-class'); ?>">
                        <a href="/gps/src/private/views/usuario/usuarioView.php" data-i18n="nav.dash.default">Gestión de Usuarios</a>
                    </li>

                </ul>
            </li>
        <?php } ?>
        <li class="nav-item">
            <a href="#!">
                <i class="ti-layout-cta-right"></i>
                <span data-i18n="nav.navigate.main">Navigation</span>
            </a>
            <ul class="tree-1">
                <li><a href="navbar-light.html" data-i18n="nav.navigate.navbar">Navbar</a>
                </li>
                <li><a href="navbar-dark.html" data-i18n="nav.navigate.navbar-inverse">Navbar Inverse</a></li>
                <li><a href="navbar-elements.html" data-i18n="nav.navigate.navbar-with-elements">Navbar With Elements</a></li>
            </ul>
        </li>
        <?php } else{?>
        <li class="nav-title" data-i18n="nav.category.ui-element">
            <i class="ti-line-dashed"></i>
            <span>UI Element</span>
        </li>
        <?php if (in_array("INICIO", $menuModulosPermisos)) { ?>
            <?php $menu = array('PANEL_CLIENTE'); ?>
            <li class="nav-item <?php if (in_array($menuActivo, $menu)) {
                                    echo ('has-class');
                                } ?> ">
                <a href="#!">
                    <i class="ti-home"></i>
                    <span data-i18n="nav.dash.main">INICIO</span>
                </a>
                <ul class="tree-1 <?php if (in_array($menuActivo, $menu)) echo ('has-class'); ?>">
                    
                    <li class=" <?php if ($menuActivo == 'PANEL_CLIENTE') echo ('has-class'); ?>">
                        <a href="/gps/src/private/views/viewInicial/clienteView.php" data-i18n="nav.dash.default"> PANEL DE CLIENTE</a>
                    </li>

                </ul>
            </li>
        <?php } ?>
        <li class="nav-item">
            <a href="#!">
                <i class="ti-crown"></i>
                <span data-i18n="nav.advance-components.main">Advance Components</span>
            </a>
            <ul class="tree-1">
                <li><a href="draggable.html" data-i18n="nav.advance-components.draggable">Draggable</a></li>
                <li><a href="bs-grid.html" data-i18n="nav.advance-components.grid-stack">Grid Stack</a></li>
                <li><a href="light-box.html" data-i18n="nav.advance-components.light-box">Light Box</a></li>
                <li><a href="modal.html" data-i18n="nav.advance-components.modal">Modal</a></li>
                <li><a href="modal-form.html" data-i18n="nav.advance-components.modal-form">Modal Form</a></li>
                <li><a href="notification.html" data-i18n="nav.advance-components.notifications">Notifications</a></li>
                <li><a href="notify.html" data-i18n="nav.advance-components.pnotify">PNOTIFY</a>
                    <label class="label label-info menu-caption">NEW</label>
                </li>
                <li><a href="rating.html" data-i18n="nav.advance-components.rating">Rating</a></li>
                <li><a href="range-slider.html" data-i18n="nav.advance-components.range-slider">Range Slider</a></li>
                <li><a href="slider.html" data-i18n="nav.advance-components.slider">Slider</a></li>
                <li><a href="syntax-highlighter.html" data-i18n="nav.advance-components.syntax-highlighter">Syntax Highlighter </a></li>
                <li><a href="tour.html" data-i18n="nav.advance-components.tour">Tour</a></li>
                <li><a href="treeview.html" data-i18n="nav.advance-components.tree-view">Tree View</a></li>
                <li><a href="nestable.html" data-i18n="nav.advance-components.nestable">Nestable</a></li>
                <li><a href="toolbar.html" data-i18n="nav.advance-components.toolbar">Toolbar</a></li>
                <li><a href="x-editable.html" data-i18n="nav.advance-components.x-editable">X-Editable</a></li>
            </ul>
        </li>
        <li class="nav-item">
            <a href="#!">
                <i class="ti-gift "></i>
                <span data-i18n="nav.extra-components.main"> Extra Components</span>
            </a>
            <ul class="tree-1">
                <li><a href="session-timeout.html" data-i18n="nav.extra-components.session-timeout">Session Timeout</a></li>
                <li><a href="session-idle-timeout.html" data-i18n="nav.extra-components.session-idle-timeout">Session Idle Timeout</a>
                </li>
                <li><a href="offline.html" data-i18n="nav.extra-components.offline">Offline</a></li>
            </ul>
        </li>
        <li class="nav-item single-item">
            <a href="animation.html">
                <i class="ti-reload rotate-refresh"></i>
                <span data-i18n="nav.animations.main"> Animations</span>
            </a>
        </li>
        <li class="nav-item single-item">
            <a href="sticky.html">
                <i class="ti-layers-alt"></i>
                <span data-i18n="nav.sticky-notes.main"> Sticky Notes</span>
                <label class="label label-danger menu-caption">HOT</label>
            </a>
        </li>
        <li class="nav-item">
            <a href="#!">
                <i class="ti-star"></i>
                <span data-i18n="nav.icons.main">Icons</span>
            </a>
            <ul class="tree-1">
                <li><a href="icon-font-awesome.html" data-i18n="nav.icons.font-awesome">Font Awesome</a></li>
                <li><a href="icon-themify.html" data-i18n="nav.icons.themify">Themify</a></li>
                <li><a href="icon-simple-line.html" data-i18n="nav.icons.simple-line-icon">Simple Line Icon</a></li>
                <li><a href="icon-ion.html" data-i18n="nav.icons.ion-icon">Ion Icon</a></li>
                <li><a href="icon-material-design.html" data-i18n="nav.icons.material-design">Material Design</a></li>
                <li><a href="icon-icofonts.html" data-i18n="nav.icons.ico-fonts">Ico Fonts</a></li>
                <li><a href="icon-weather.html" data-i18n="nav.icons.weather-icon">Weather Icon</a></li>
                <li><a href="icon-typicons.html" data-i18n="nav.icons.typicons">Typicons</a></li>
                <li><a href="icon-flags.html" data-i18n="nav.icons.flags">Flags</a></li>
            </ul>
        </li>
        
        <?php } ?>
        <!-- <li class="nav-title" data-i18n="nav.category.forms">
            <i class="ti-line-dashed"></i>
            <span>Forms</span>
        </li>
        <li class="nav-item">
            <a href="#!">
                <i class="ti-layers"></i>
                <span data-i18n="nav.form-components.main">Form Components</span>
            </a>
            <ul class="tree-1">
                <li><a href="form-elements-component.html" data-i18n="nav.form-components.form-components">Form Components</a></li>
                <li><a href="form-elements-add-on.html
                            " data-i18n="nav.form-components.form-elements-add-on
                            ">Form-Elements-Add-On
                    </a></li>
                <li><a href="form-elements-advance.html" data-i18n="nav.form-components.form-elements-advance">Form-Elements-Advance</a></li>
                <li><a href="form-validation.html" data-i18n="nav.form-components.form-validation">Form Validation</a></li>
            </ul>
        </li>
        <li class="nav-item single-item">
            <a href="form-picker.html">
                <i class="ti-pencil-alt"></i>
                <span data-i18n="nav.form-pickers.main"> Form Picker </span>
                <label class="label label-warning menu-caption">NEW</label>
            </a>
        </li>
        <li class="nav-item">
            <a href="#!">
                <i class="ti-layout-cta-btn-right"></i>
                <span data-i18n="nav.json-form.main">JSON Form</span>
                <label class="label label-danger menu-caption">HOT</label>
            </a>
            <ul class="tree-1">
                <li><a href="json-forms/simple-form.html" data-i18n="nav.json-form.simple-form">Simple Form</a></li>
                <li><a href="json-forms/clubs.html" data-i18n="nav.json-form.clubs-view">Clubs(View Selector)</a></li>
                <li><a href="json-forms/customer-form.html" data-i18n="nav.json-form.customer-form">Customer Form</a></li>
                <li><a href="json-forms/customer-profile-display-form.html" data-i18n="nav.json-form.profile-display">Profile Display</a></li>
                <li><a href="json-forms/customer-profile-edit-form.html" data-i18n="nav.json-form.profile-edit">Profile Edit</a></li>
                <li><a href="json-forms/customer-profile-read-only.html" data-i18n="nav.json-form.profile-ready-only">Profile Ready Only</a></li>
                <li><a href="json-forms/json-form-fields.html" data-i18n="nav.json-form.form-fields">Form Fields</a></li>
                <li><a href="json-forms/registration-click-validation.html" data-i18n="nav.json-form.registration-validation">Registration Validation</a></li>
                <li><a href="json-forms/registration-automatic-validation.html" data-i18n="nav.json-form.automatic-validation">Automatic Validation</a></li>
                <li><a href="json-forms/localized-login.html" data-i18n="nav.json-form.localized-login">Localized Login</a></li>
            </ul>
        </li>
        <li class="nav-item single-item">
            <a href="form-select.html">
                <i class="ti-shortcode"></i>
                <span data-i18n="nav.form-select.main">Form Select </span>
            </a>
        </li>
        <li class="nav-item single-item">
            <a href="form-masking.html">
                <i class="ti-write"></i>
                <span data-i18n="nav.form-masking.main">Form Masking </span>
            </a>
        </li>
        <li class="nav-item single-item">
            <a href="form-wizard.html">
                <i class="ti-archive"></i>
                <span data-i18n="nav.form-wizard.main">Form Wizard </span>
            </a>
        </li>
        <li class="nav-item">
            <a href="#!">
                <i class="ti-receipt"></i>
                <span data-i18n="nav.ready-to-use.main">Ready To Use</span>
                <label class="label label-danger menu-caption">HOT</label>
            </a>
            <ul class="tree-1">
                <li><a href="ready-cloned-elements-form.html" data-i18n="nav.ready-to-use.cloned-elements-form">Cloned Elements Form</a></li>
                <li><a href="ready-currency-form.html" data-i18n="nav.ready-to-use.currency-form">Currency Form </a></li>
                <li><a href="ready-form-booking.html" data-i18n="nav.ready-to-use.booking-form">Booking Form</a></li>
                <li><a href="ready-form-booking-multi-steps.html" data-i18n="nav.ready-to-use.booking-multi-steps-form"> Booking Multi Steps Form</a></li>
                <li><a href="ready-form-comment.html" data-i18n="nav.ready-to-use.comment-form">Comment Form</a></li>
                <li><a href="ready-form-contact.html" data-i18n="nav.ready-to-use.contact-form"> Contact Form</a></li>
                <li><a href="ready-job-application-form.html" data-i18n="nav.ready-to-use.job-application-form">Job Application Form</a></li>
                <li><a href="ready-js-addition-form.html" data-i18n="nav.ready-to-use.jS-addition-form">JS Addition Form</a></li>
                <li><a href="ready-login-form.html" data-i18n="nav.ready-to-use.login-form"> Login Form</a></li>
                <li><a href="ready-popup-modal-form.html" target="_blank" data-i18n="nav.ready-to-use.popup-modal-form">Popup Modal Form</a></li>
                <li><a href="ready-registration-form.html" data-i18n="nav.ready-to-use.registration-form">Registration Form</a>
                </li>
                <li><a href="ready-review-form.html" data-i18n="nav.ready-to-use.review-form">Review Form</a></li>
                <li><a href="ready-subscribe-form.html" data-i18n="nav.ready-to-use.subscribe-form">Subscribe Form</a></li>
                <li><a href="ready-suggestion-form.html" data-i18n="nav.ready-to-use.suggestion-form">Suggestion Form</a></li>
                <li><a href="ready-tabs-form.html" data-i18n="nav.ready-to-use.tabs-form">Tabs Form</a></li>
            </ul>
        </li>
        <li class="nav-title" data-i18n="nav.category.tables">
            <i class="ti-line-dashed"></i>
            <span>Tables</span>
        </li>
        <li class="nav-item">
            <a href="#!">
                <i class="ti-layout-grid3-alt"></i>
                <span data-i18n="nav.bootstrap-table.main">Bootstrap Table</span>
            </a>
            <ul class="tree-1">
                <li><a href="bs-basic-table.html" data-i18n="nav.bootstrap-table.basic-table">Basic Table</a></li>
                <li><a href="bs-table-sizing.html" data-i18n="nav.bootstrap-table.sizing-table">Sizing Table</a></li>
                <li><a href="bs-table-border.html" data-i18n="nav.bootstrap-table.border-table">Border Table</a></li>
                <li><a href="bs-table-styling.html" data-i18n="nav.bootstrap-table.styling-table">Styling Table</a></li>
            </ul>
        </li>
        <li class="nav-item">
            <a href="#!">
                <i class="ti-widgetized"></i>
                <span data-i18n="nav.data-table.main">Data Table</span>
            </a>
            <ul class="tree-1">
                <li><a href="dt-basic.html" data-i18n="nav.data-table.basic-initialization">Basic Initialization</a></li>
                <li><a href="dt-advance.html" data-i18n="nav.data-table.advance-initialization">Advance Initialization</a></li>
                <li><a href="dt-styling.html" data-i18n="nav.data-table.styling">Styling</a></li>
                <li><a href="dt-api.html" data-i18n="nav.data-table.api">API</a></li>
                <li><a href="dt-ajax.html" data-i18n="nav.data-table.ajax">Ajax</a></li>
                <li><a href="dt-server-side.html" data-i18n="nav.data-table.server-side">Server Side</a></li>
                <li><a href="dt-plugin.html" data-i18n="nav.data-table.plug-in">Plug-In</a></li>
                <li><a href="dt-data-sources.html" data-i18n="nav.data-table.data-sources">Data Sources</a></li>
            </ul>
        </li>
        <li class="nav-item">
            <a href="#!">
                <i class="ti-loop"></i>
                <span data-i18n="nav.data-table-extensions.main">Data Table Extensions</span>
            </a>
            <ul class="tree-1">
                <li><a href="dt-ext-autofill.html" data-i18n="nav.data-table-extensions.autofill">AutoFill</a></li>
                <li class="nav-sub-item"><a href="#" data-i18n="nav.data-table-extensions.button.main">Button</a>
                    <ul class="tree-2">
                        <li><a href="dt-ext-basic-buttons.html" data-i18n="nav.data-table-extensions.button.basic-button">Basic Button</a></li>
                        <li><a href="dt-ext-buttons-flash.html" data-i18n="nav.data-table-extensions.button.flash-button">Flash Button</a></li>
                        <li><a href="dt-ext-buttons-html-5-data-export.html" data-i18n="nav.data-table-extensions.button.html-data-export">Html-5 Data Export </a></li>
                        <li><a href="dt-ext-buttons-print.html" data-i18n="nav.data-table-extensions.button.print-button">Print Button</a></li>
                    </ul>
                </li>
                <li><a href="dt-ext-col-reorder.html" data-i18n="nav.data-table-extensions.col-reorder">Col Reorder</a></li>
                <li><a href="dt-ext-fixed-columns.html" data-i18n="nav.data-table-extensions.fixed-columns">Fixed Columns</a></li>
                <li><a href="dt-ext-fixed-header.html" data-i18n="nav.data-table-extensions.fixed-header">Fixed Header</a></li>
                <li><a href="dt-ext-key-table.html" data-i18n="nav.data-table-extensions.key-table">Key Table</a></li>
                <li><a href="dt-ext-responsive.html" data-i18n="nav.data-table-extensions.responsive">Responsive</a></li>
                <li><a href="dt-ext-row-reorder.html" data-i18n="nav.data-table-extensions.row-recorder">Row Recorder</a></li>
                <li><a href="dt-ext-scroller.html" data-i18n="nav.data-table-extensions.scroller">Scroller</a></li>
                <li><a href="dt-ext-select.html" data-i18n="nav.data-table-extensions.select-tbl">Select Table</a></li>
            </ul>
        </li>
        <li class="nav-item single-item">
            <a href="foo-table.html">
                <i class="ti-view-list-alt"></i>
                <span data-i18n="nav.foo-table.main"> FooTable</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="#!">
                <i class="ti-view-list"></i>
                <span data-i18n="nav.handson-table.main"> Handson Table</span>
            </a>
            <ul class="tree-1">
                <li><a href="handson-appearance.html" data-i18n="nav.handson-table.appearance">Appearance</a></li>
                <li><a href="handson-data-operation.html" data-i18n="nav.handson-table.data-operation">Data Operation</a></li>
                <li><a href="handson-rows-cols.html" data-i18n="nav.handson-table.rows-columns">Rows Columns</a></li>
                <li><a href="handson-columns-only.html" data-i18n="nav.handson-table.columns-Only">Columns Only</a></li>
                <li><a href="handson-cell-features.html" data-i18n="nav.handson-table.cell-features">Cell Features</a></li>
                <li><a href="handson-cell-types.html" data-i18n="nav.handson-table.cell-types">Cell Types</a></li>
                <li><a href="handson-integrations.html" data-i18n="nav.handson-table.integrations">Integrations</a></li>
                <li><a href="handson-rows-only.html" data-i18n="nav.handson-table.rows-Only">Rows Only</a></li>
                <li><a href="handson-utilities.html" data-i18n="nav.handson-table.utilities">Utilities</a></li>
            </ul>
        </li>
        <li class="nav-item single-item">
            <a href="editable-table.html">
                <i class="ti-write"></i>
                <span data-i18n="nav.editable-table.main">Editable Table</span>
            </a>
        </li>
        <li class="nav-title" data-i18n="nav.category.chart-and-maps">
            <i class="ti-line-dashed"></i>
            <span>Chart And Maps</span>
            <label class="label label-info menu-caption">15P+ </label>
        </li>
        <li class="nav-item">
            <a href="#!">
                <i class="ti-bar-chart-alt"></i>
                <span data-i18n="nav.charts.main">Charts</span>
            </a>
            <ul class="tree-1">
                <li><a href="chart-google.html" data-i18n="nav.charts.google-chart">Google Chart</a></li>
                <li><a href="chart-echart.html" data-i18n="nav.charts.echarts">Echarts</a></li>
                <li><a href="chart-chartjs.html" data-i18n="nav.charts.chartjs">ChartJs</a></li>
                <li><a href="chart-list.html" data-i18n="nav.charts.list-chart">List Chart</a></li>
                <li><a href="chart-float.html" data-i18n="nav.charts.float-chart">Float Chart</a></li>
                <li><a href="chart-knob.html" data-i18n="nav.charts.know-chart">Know chart</a></li>
                <li><a href="chart-morris.html" data-i18n="nav.charts.morris-chart">Morris Chart</a></li>
                <li><a href="chart-nvd3.html" data-i18n="nav.charts.nvd3-chart">Nvd3 Chart</a></li>
                <li><a href="chart-peity.html" data-i18n="nav.charts.peity-chart">Peity Chart</a></li>
                <li><a href="chart-radial.html" data-i18n="nav.charts.radial chart">Radial Chart</a></li>
                <li><a href="chart-rickshaw.html" data-i18n="nav.charts.rickshaw-chart">Rickshaw Chart</a></li>
                <li><a href="chart-sparkline.html" data-i18n="nav.charts.sparkline-chart">Sparkline Chart</a></li>
                <li><a href="chart-c3.html" data-i18n="nav.charts.c3-chart">C3 Chart</a></li>
            </ul>
        </li>
        <li class="nav-item">
            <a href="#!">
                <i class="ti-map-alt"></i>
                <span data-i18n="nav.maps.main">Maps</span>
            </a>
            <ul class="tree-1">
                <li><a href="map-google.html" data-i18n="nav.maps.google-maps">Google Maps</a></li>
                <li><a href="map-vector.html" data-i18n="nav.maps.vector-map">Vector Maps</a></li>
                <li><a href="map-api.html" data-i18n="nav.maps.google-map-api">Google Map Search API</a></li>
                <li><a href="location.html" data-i18n="nav.maps.location">Location</a></li>
            </ul>
        </li>
        <li class="nav-item single-item">
            <a href="http://flatable.phoenixcoded.net/default/landingpage/index.html" target="_blank">
                <i class="ti-mobile"></i>
                <span data-i18n="nav.landing-page.main"> Landing Page</span>
            </a>
        </li>
        <li class="nav-title" data-i18n="nav.category.pages">
            <i class="ti-line-dashed"></i>
            <span>Pages</span>
        </li>
        <li class="nav-item">
            <a href="#!">
                <i class="ti-id-badge"></i>
                <span data-i18n="nav.authentication.main">Authentication</span>
            </a>
            <ul class="tree-1">
                <li><a href="auth-normal-sign-in.html" target="_blank" data-i18n="nav.authentication.login-bg-image">Login With BG Image</a></li>
                <li><a href="auth-sign-in-social.html" target="_blank" data-i18n="nav.authentication.login-soc-icon">Login With Social Icon</a></li>
                <li><a href="auth-sign-in-social-header-footer.html" target="_blank" data-i18n="nav.authentication.login-soc-h-f">Login Social With Header And Footer</a></li>
                <li><a href="auth-normal-sign-in-header-footer.html" target="_blank" data-i18n="nav.authentication.login-h-f">Login With Header And Footer</a></li>
                <li><a href="auth-sign-up.html" target="_blank" data-i18n="nav.authentication.registration-bg-image">Registration BG Image</a></li>
                <li><a href="auth-sign-up-social.html" target="_blank" data-i18n="nav.authentication.registration-soc-icon">Registration Social Icon</a></li>
                <li><a href="auth-sign-up-social-header-footer.html" target="_blank" data-i18n="nav.authentication.registration-soc-h-f">Registration Social With Header And Footer</a></li>
                <li><a href="auth-sign-up-header-footer.html" target="_blank" data-i18n="nav.authentication.registration-h-f">Registration With Header And Footer</a></li>
                <li><a href="auth-multi-step-sign-up.html" target="_blank" data-i18n="nav.authentication.multi-step-registration">Multi Step Registration</a></li>
                <li><a href="auth-reset-password.html" target="_blank" data-i18n="nav.authentication.forgot-password">Forgot Password</a></li>
                <li><a href="auth-lock-screen.html" target="_blank" data-i18n="nav.authentication.lock-screen">Lock Screen</a></li>
                <li><a href="auth-modal.html" target="_blank" data-i18n="nav.authentication.modal">Modal</a></li>
            </ul>
        </li>
        <li class="nav-item">
            <a href="#!">
                <i class="ti-settings"></i>
                <span data-i18n="nav.maintenance.main">Maintenance</span>
            </a>
            <ul class="tree-1">
                <li><a href="error.html" data-i18n="nav.maintenance.error">Error</a></li>
                <li><a href="comming-soon.html" data-i18n="nav.maintenance.comming-soon">Comming Soon</a></li>
                <li><a href="offline-ui.html" data-i18n="nav.maintenance.offline-ui">Offline UI</a></li>
            </ul>
        </li>
        <li class="nav-item">
            <a href="#!">
                <i class="ti-user"></i>
                <span data-i18n="nav.user-profile.main">User Profile</span>
            </a>
            <ul class="tree-1">
                <li><a href="timeline.html" data-i18n="nav.user-profile.timeline">Timeline</a></li>
                <li><a href="timeline-social.html" data-i18n="nav.user-profile.timeline-social">Timeline Social</a></li>
                <li><a href="user-profile.html" data-i18n="nav.user-profile.user-profile">User Profile</a></li>
                <li><a href="user-card.html" data-i18n="nav.user-profile.user-card">User Card</a></li>
            </ul>
        </li>
        <li class="nav-item">
            <a href="#!">
                <i class="ti-comment-alt"></i>
                <span data-i18n="nav.blog.main">Blog</span>
            </a>
            <ul class="tree-1">
                <li><a href="blog.html" data-i18n="nav.blog.blog">Blog</a></li>
                <li><a href="blog-detail.html" data-i18n="nav.blog.blog-detail">Blog Detail</a></li>
                <li><a href="blog-detail-left.html" data-i18n="nav.blog.blog-left-side">Blog With Left Sidebar</a></li>
                <li><a href="blog-detail-right.html" data-i18n="nav.blog.blog-right-sidebar">Blog With Right Sidebar</a>
                </li>
            </ul>
        </li>
        <li class="nav-item">
            <a href="#!">
                <i class="ti-shopping-cart"></i>
                <span data-i18n="nav.e-commerce.main">E-Commerce</span>
                <label class="label label-danger menu-caption">NEW</label>
            </a>
            <ul class="tree-1">
                <li><a href="product.html" data-i18n="nav.e-commerce.product">Product</a></li>
                <li><a href="product-list.html" data-i18n="nav.e-commerce.product-list">Product List</a></li>
                <li><a href="product-edit.html" data-i18n="nav.e-commerce.product-edit">Product Edit</a></li>
                <li><a href="product-detail.html" data-i18n="nav.e-commerce.product-detail">Product Detail</a></li>
                <li><a href="product-cart.html" data-i18n="nav.e-commerce.product-card">Product Card</a></li>
                <li><a href="product-payment.html" data-i18n="nav.e-commerce.credit-card-form">Credit Card Form </a></li>
            </ul>
        </li>
        <li class="nav-item">
            <a href="#!">
                <i class="ti-email"></i>
                <span data-i18n="nav.email.main">Email</span>
            </a>
            <ul class="tree-1">
                <li><a href="email-compose.html" data-i18n="nav.email.compose-mail">Compose Email</a></li>
                <li><a href="email-inbox.html" data-i18n="nav.email.inbox">Inbox</a></li>
                <li><a href="email-read.html" data-i18n="nav.email.read-read-mail">Read Mail</a></li>
                <li class="nav-sub-item"><a href="#" data-i18n="nav.email.email-template.main">Email Template</a>
                    <ul class="tree-2">
                        <li><a href="email-templates/email-welcome.html" data-i18n="nav.email.email-template.welcome-email">Welcome Email</a></li>
                        <li><a href="email-templates/email-password.html" data-i18n="nav.email.email-template.reset-password">Reset Password</a></li>
                        <li><a href="email-templates/email-newsletter.html" data-i18n="nav.email.email-template.newsletter-email">Newsletter Email</a></li>
                        <li><a href="email-templates/email-launch.html" data-i18n="nav.email.email-template.app-launch">App Launch</a></li>
                        <li><a href="email-templates/email-activation.html" data-i18n="nav.email.email-template.activation-code">Activation Code</a></li>
                    </ul>
                </li>
            </ul>
        </li>
        <li class="nav-title" data-i18n="nav.category.app">
            <i class="ti-line-dashed"></i>
            <span>App</span>
        </li>
        <li class="nav-item single-item">
            <a href="chat.html">
                <i class="ti-comments"></i>
                <span data-i18n="nav.chat.main"> Chat</span>
            </a>
        </li>
        <li class="nav-item single-item">
            <a href="crm-contact.html">
                <i class="ti-layout-list-thumb"></i>
                <span data-i18n="nav.crm-contact.main"> CRM Contact</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="#!">
                <i class="ti-dribbble"></i>
                <span data-i18n="nav.social.main">Social</span>
            </a>
            <ul class="tree-1">
                <li><a href="fb-wall.html" data-i18n="nav.social.fb-wall">Fb Wall</a></li>
                <li><a href="message.html" data-i18n="nav.social.messages">Messages</a></li>
            </ul>
        </li>
        <li class="nav-item">
            <a href="#!">
                <i class="ti-check-box"></i>
                <span data-i18n="nav.task.main">Task</span>
            </a>
            <ul class="tree-1">
                <li><a href="task-list.html" data-i18n="nav.task.task-list">Task List</a></li>
                <li><a href="task-board.html" data-i18n="nav.task.task-board">Task Board</a></li>
                <li><a href="task-detail.html" data-i18n="nav.task.task-detail">Task Detail</a></li>
                <li><a href="issue-list.html" data-i18n="nav.task.issue list">Issue List</a></li>
            </ul>
        </li>
        <li class="nav-item">
            <a href="#!">
                <i class="ti-notepad"></i>
                <span data-i18n="nav.to-do.main">To-Do</span>
            </a>
            <ul class="tree-1">
                <li><a href="todo.html" data-i18n="nav.to-do.todo">To-Do</a></li>
                <li><a href="notes.html" data-i18n="nav.to-do.notes">Notes</a></li>
            </ul>
        </li>
        <li class="nav-item">
            <a href="#!">
                <i class="ti-gallery"></i>
                <span data-i18n="nav.gallery.main">Gallery</span>
            </a>
            <ul class="tree-1">
                <li><a href="gallery-grid.html" data-i18n="nav.gallery.gallery-grid">Gallery-Grid</a></li>
                <li><a href="gallery-masonry.html" data-i18n="nav.gallery.masonry-gallery">Masonry Gallery</a></li>
                <li><a href="gallery-advance.html" data-i18n="nav.gallery.advance-gallery">Advance Gallery</a></li>
            </ul>
        </li>
        <li class="nav-item">
            <a href="#!">
                <i class="ti-search"></i>
                <span data-i18n="nav.search.main">Search</span>
            </a>
            <ul class="tree-1">
                <li><a href="search-result.html" data-i18n="nav.search.simple-search">Simple Search</a></li>
                <li><a href="search-result2.html" data-i18n="nav.search.grouping-search">Grouping Search</a></li>
            </ul>
        </li>
        <li class="nav-item">
            <a href="#!">
                <i class="ti-medall-alt"></i>
                <span data-i18n="nav.job-search.main">Job Search</span>
                <label class="label label-danger menu-caption">NEW</label>
            </a>
            <ul class="tree-1">
                <li><a href="job-card-view.html" data-i18n="nav.job-search.card-view">Card View</a></li>
                <li><a href="job-details.html" data-i18n="nav.job-search.job-detailed">Job Detailed</a></li>
                <li><a href="job-find.html" data-i18n="nav.job-search.job-find">Job Find</a></li>
                <li><a href="job-panel-view.html" data-i18n="nav.job-search.job-panel-view">Job Panel View</a></li>
            </ul>
        </li>
        <li class="nav-title" data-i18n="nav.category.extension">
            <i class="ti-line-dashed"></i>
            <span>Extension</span>
        </li>
        <li class="nav-item">
            <a href="#!">
                <i class="ti-pencil-alt"></i>
                <span data-i18n="nav.editor.main">Editor</span>
            </a>
            <ul class="tree-1">
                <li><a href="ck-editor.html" data-i18n="nav.editor.ck-editor">CK-Editor</a></li>
                <li><a href="wysiwyg-editor.html" data-i18n="nav.editor.wysiwyg-editor">WYSIWYG Editor</a></li>
                <li><a href="ace-editor.html" data-i18n="nav.editor.ace-editor">Ace Editor</a></li>
                <li><a href="summernote.html" data-i18n="nav.editor.summer-note-editor">Summer Note Editor</a></li>
                <li><a href="long-press-editor.html" data-i18n="nav.editor.long-press-editor">Long Press Editor</a></li>
            </ul>
        </li>
        <li class="nav-item">
            <a href="#!">
                <i class="ti-layout-media-right"></i>
                <span data-i18n="nav.invoice.main">Invoice</span>
            </a>
            <ul class="tree-1">
                <li><a href="invoice.html" data-i18n="nav.invoice.invoice">Invoice</a></li>
                <li><a href="invoice-summary.html" data-i18n="nav.invoice.invoice-summery">Invoice Summary</a></li>
                <li><a href="invoice-list.html" data-i18n="nav.invoice.invoice-list">Invoice List</a></li>
            </ul>
        </li>
        <li class="nav-item">
            <a href="#!">
                <i class="ti-calendar"></i>
                <span data-i18n="nav.event-calendar.main">Event Calendar</span>
            </a>
            <ul class="tree-1">
                <li><a href="event-full-calender.html" data-i18n="nav.full-calendar.full-calendar">Full Calendar</a></li>
                <li><a href="event-clndr.html" data-i18n="nav.clnder.clnder">CLNDER
                        <label class="label label-info menu-caption">New</label>
                    </a></li>
            </ul>
        </li>
        <li class="nav-item single-item">
            <a href="image-crop.html">
                <i class="ti-cut"></i>
                <span data-i18n="nav.image-cropper.main"> Image Cropper</span>
            </a>
        </li>
        <li class="nav-item single-item">
            <a href="file-upload.html">
                <i class="ti-cloud-up"></i>
                <span data-i18n="nav.file-upload.main">File Upload</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="#!">
                <i class="ti-world"></i>
                <span data-i18n="nav.internationalize.main">Internationalize</span>
                <label class="label label-danger menu-caption">HOT</label>
            </a>
            <ul class="tree-1">
                <li><a href="internationalization/internationalization-after-init.html" data-i18n="nav.internationalize.after-init">After Init</a></li>
                <li><a href="internationalization/internationalization-fallback.html" data-i18n="nav.internationalize.fallback">Fallback</a></li>
                <li><a href="internationalization/internationalization-on-init.html" data-i18n="nav.internationalize.on-int">On Init</a></li>
                <li><a href="internationalization/internationalization-resources.html" data-i18n="nav.internationalize.resources">Resources</a></li>
                <li><a href="internationalization/internationalization-xhr-backend.html" data-i18n="nav.internationalize.xhr-backend">XHR Backend</a></li>
            </ul>
        </li>
        <li class="nav-item single-item">
            <a href="change-loges.html">
                <i class="ti-list"></i>
                <span data-i18n="nav.change-loges.main">Change Loges</span>
                <label class="label label-warning menu-caption">1.0</label>
            </a>
        </li>
        <li class="nav-title" data-i18n="nav.category.other">
            <i class="ti-line-dashed"></i>
            <span> Other</span>
        </li>
        <li class="nav-item">
            <a href="#!">
                <i class="ti-direction-alt"></i>
                <span data-i18n="nav.menu-levels.main">Menu Levels</span>
            </a>
            <ul class="tree-1">
                <li><a href="#!" data-i18n="nav.menu-levels.menu-level-21">Menu Level 2.1</a></li>
                <li class="nav-sub-item"><a href="#" data-i18n="nav.menu-levels.menu-level-22.main">Menu Level 2.2</a>
                    <ul class="tree-2">
                        <li><a href="#" data-i18n="nav.menu-levels.menu-level-22.menu-level-31">Menu Level 3.1</a></li>
                        <li class="nav-sub-item-3"><a href="#" data-i18n="nav.menu-levels.menu-level-22.menu-level-32.main">Menu Level 3.2 </a>
                            <ul class="tree-3">
                                <li><a href="#" data-i18n="nav.menu-levels.menu-level-22.menu-level-32.menu-level-41">Menu Level 4.1</a> </li>
                                <li class="nav-sub-item-4"><a href="#" data-i18n="nav.menu-levels.menu-level-22.menu-level-32.menu-level-42">Menu Level 4.2</a>
                                    <ul class="tree-4">
                                        <li><a href="#" data-i18n="nav.menu-levels.menu-level-22.menu-level-32.menu-level-41">Menu Level 5.1</a> </li>
                                        <li><a href="#" data-i18n="nav.menu-levels.menu-level-22.menu-level-32.menu-level-42">Menu Level 5.2</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <li><a href="#!" data-i18n="nav.menu-levels.menu-level-23">Menu Level 2.3</a></li>
            </ul>
        </li>
        <li class="nav-item single-item">
            <a href="#!" class="nav-link disabled">
                <i class="ti-na"></i>
                <span data-i18n="nav.disabled-menu.main"> Disabled Menu</span>
            </a>
        </li>
        <li class="nav-item single-item">
            <a href="sample-page.html">
                <i class="ti-layout-sidebar-left"></i>
                <span data-i18n="nav.sample-page.main">Sample Page</span>
            </a>
        </li>
        <li class="nav-title" data-i18n="nav.category.support">
            <i class="ti-line-dashed"></i>
            <span>Support</span>
        </li>
        <li class="nav-item single-item">
            <a href="#" target="_blank">
                <i class="ti-file"></i>
                <span data-i18n="nav.documentation.main">Documentation</span>
            </a>
        </li>
        <li class="nav-item single-item">
            <a href="#">
                <i class="ti-layout-list-post"></i>
                <span data-i18n="nav.submit-issue.main">Submit Issue</span>
            </a>
        </li> -->
    </ul>
</div>