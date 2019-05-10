<?php
/**
 * Ngo_Charity_Lite_ - About page class
 * @package Ngo_Charity_Lite
 * @subpackage Admin
 * @since 1.0.0
 */
if ( ! class_exists( 'Ngo_Charity_Lite_About_Page' ) ) {

	// Include utils functions

	/**
	 * Singleton class used for generating the about page of the theme.
	 */
	class Ngo_Charity_Lite_About_Page {
		/**
		 * Define the version of the class.
		 *
		 * @var string $version The Ngo_Charity_Lite_About_Page class version.
		 */
		private $version = '1.0.0';
		/**
		 * Used for loading the texts and setup the actions inside the page.
		 *
		 * @var array $config The configuration array for the theme used.
		 */
		private $config;
		/**
		 * Get the theme name using wp_get_theme.
		 *
		 * @var string $theme_name The theme name.
		 */
		private $theme_name;
		/**
		 * Get the theme slug ( theme folder name ).
		 *
		 * @var string $theme_slug The theme slug.
		 */
		private $theme_slug;
		/**
		 * The current theme object.
		 *
		 * @var WP_Theme $theme The current theme.
		 */
		private $theme;
		/**
		 * Holds the theme version.
		 *
		 * @var string $theme_version The theme version.
		 */
		private $theme_version;
		/**
		 * Define the menu item name for the page.
		 *
		 * @var string $menu_name The name of the menu name under Appearance settings.
		 */
		private $menu_name;
		/**
		 * Define the page title name.
		 *
		 * @var string $page_name The title of the About page.
		 */
		private $page_name;
		/**
		 * Define the page tabs.
		 *
		 * @var array $tabs The page tabs.
		 */
		private $tabs;
		/**
		 * Define the html notification content displayed upon activation.
		 *
		 * @var string $notification The html notification content.
		 */
		private $notification;
		/**
		 * The single instance of Ngo_Charity_Lite_About_Page
		 *
		 * @var Ngo_Charity_Lite_About_Page $instance The  Ngo_Charity_Lite_About_Page instance.
		 */
		private static $instance;

		/**
		 * The Main Ngo_Charity_Lite_About_Page instance.
		 *
		 * We make sure that only one instance of Ngo_Charity_Lite_About_Page exists in the memory at one time.
		 *
		 * @param array $config The configuration array.
		 */
		public static function init( $config ) {
			if ( ! isset( self::$instance ) && ! ( self::$instance instanceof Ngo_Charity_Lite_About_Page ) ) {
				self::$instance = new Ngo_Charity_Lite_About_Page;
				if ( ! empty( $config ) && is_array( $config ) ) {
					self::$instance->config = $config;
					self::$instance->setup_config();
					self::$instance->setup_actions();
				}
			}

		}

		/**
		 * Setup the class props based on the config array.
		 */
		public function setup_config() {
			$theme = wp_get_theme();
			if ( is_child_theme() ) {
				$this->theme_name = $theme->parent()->get( 'Name' );
				$this->theme      = $theme->parent();
			} else {
				$this->theme_name = $theme->get( 'Name' );
				$this->theme      = $theme->parent();
			}
			$this->theme_version = $theme->get( 'Version' );
			$this->theme_slug    = $theme->get_template();
			$this->menu_name     = isset( $this->config['menu_name'] ) ? $this->config['menu_name'] : 'About ' . $this->theme_name;
			$this->page_name     = isset( $this->config['page_name'] ) ? $this->config['page_name'] : 'About ' . $this->theme_name;
			$this->notification  = isset( $this->config['notification'] ) ? $this->config['notification'] : '';
			$this->tabs          = isset( $this->config['tabs'] ) ? $this->config['tabs'] : array();

		}

		/**
		 * Setup the actions used for this page.
		 */
		public function setup_actions() {

			add_action( 'admin_menu', array( $this, 'register' ) );
			/* activation notice */
			add_action( 'load-themes.php', array( $this, 'activation_admin_notice' ) );
			/* enqueue script and style for about page */
			add_action( 'admin_enqueue_scripts', array( $this, 'style_and_scripts' ) );

			/* ajax callback for dismissable required actions */
			add_action( 'wp_ajax_ti_about_page_dismiss_required_action', array( $this, 'dismiss_required_action_callback' ) );
			add_action( 'wp_ajax_nopriv_ti_about_page_dismiss_required_action', array( $this, 'dismiss_required_action_callback' ) );
		}

		/**
		 * Hide required tab if no actions present.
		 *
		 * @return bool Either hide the tab or not.
		 */
		public function hide_required( $value, $tab ) {
			if ( $tab != 'recommended_actions' ) {
				return $value;
			}
			$required = $this->get_required_actions();
			if ( count( $required ) == 0 ) {
				return false;
			} else {
				return true;
			}
		}


		/**
		 * Register the menu page under Appearance menu.
		 */
		function register() {
			if ( ! empty( $this->menu_name ) && ! empty( $this->page_name ) ) {

				$count = 0;

				$actions_count = $this->get_required_actions();
                foreach ($actions_count as $a=>$r) {
                    $active_slug= $r['plugin_slug'];
                    if($active_slug == 'contact-form-7')
                        $active_slug='wp-contact-form-7';
                    if(is_plugin_active($r['plugin_slug'].'/'.$active_slug.'.php')){
                        unset($actions_count[$a]);
                    }
                }
				if ( ! empty( $actions_count ) ) {
					$count = count( $actions_count );
				}

				$title = $count > 0 ? $this->page_name . '<span class="badge-action-count">' . esc_html( $count ) . '</span>' : $this->page_name;

				add_theme_page(
					$this->menu_name, $title, 'activate_plugins', $this->theme_slug . '-welcome', array(
						$this,
						'ngo_charity_lite_about_page_render',
					)
				);
			}
		}

		/**
		 * Adds an admin notice upon successful activation.
		 */
		public function activation_admin_notice() {
			global $pagenow;
			if ( is_admin() && ( 'themes.php' == $pagenow ) && isset( $_GET['activated'] ) ) {
				add_action( 'admin_notices', array( $this, 'ngo_charity_lite_about_page_welcome_admin_notice' ), 99 );
			}
		}

		/**
		 * Display an admin notice linking to the about page
		 */
		public function ngo_charity_lite_about_page_welcome_admin_notice() {
			if ( ! empty( $this->notification ) ) {
				echo '<div class="updated notice is-dismissible">';
				echo wp_kses_post( $this->notification );
				echo '</div>';
			}
		}

		/**
		 * Render the main content page.
		 */
		public function ngo_charity_lite_about_page_render() {

			if ( ! empty( $this->config['welcome_title'] ) ) {
				$welcome_title = $this->config['welcome_title'];
			}
			if ( ! empty( $this->config['welcome_content'] ) ) {
				$welcome_content = $this->config['welcome_content'];
			}

			if ( ! empty( $welcome_title ) || ! empty( $welcome_content ) || ! empty( $this->tabs ) ) {

				echo '<div class="wrap ngo-charity-about-wrap about-wrap epsilon-wrap">';

				if ( ! empty( $welcome_title ) ) {
					echo '<h1>';
					echo esc_html( $welcome_title );
					if ( ! empty( $this->theme_version ) ) {
						echo esc_html( $this->theme_version ) . ' </sup>';
					}
					echo '</h1>';
				}
				if ( ! empty( $welcome_content ) ) {
					echo '<div class="about-text">' . wp_kses_post( $welcome_content ) . '</div>';
				}

				/* Display tabs */
				if ( ! empty( $this->tabs ) ) {
					$active_tab = isset( $_GET['tab'] ) ? wp_unslash( $_GET['tab'] ) : 'getting_started';

					echo '<h2 class="nav-tab-wrapper wp-clearfix">';

					$actions_count = $this->get_required_actions();

					$count = 0;

					if ( ! empty( $actions_count ) ) {
						$count = count( $actions_count );
					}

					foreach ( $this->tabs as $tab_key => $tab_name ) {

						if ( ( $tab_key != 'changelog' ) || ( ( $tab_key == 'changelog' ) && isset( $_GET['show'] ) && ( $_GET['show'] == 'yes' ) ) ) {

//
							echo '<a href="' . esc_url( admin_url( 'themes.php?page=' . $this->theme_slug . '-welcome' ) ) . '&tab=' . $tab_key . '" class="nav-tab ' . ( $active_tab == $tab_key ? 'nav-tab-active' : '' ) . '" role="tab" data-toggle="tab">';
							echo esc_html( $tab_name );
							if ( $tab_key == 'recommended_actions' ) {
								$count = 0;

								$actions_count = $this->get_required_actions();

                                foreach ($actions_count as $a=>$r) {
                                    $active_slug= $r['plugin_slug'];
                                    if($active_slug == 'contact-form-7')
                                        $active_slug='wp-contact-form-7';
                                    if(is_plugin_active($r['plugin_slug'].'/'.$active_slug.'.php')){
                                        unset($actions_count[$a]);
                                    }
                                }
								if ( ! empty( $actions_count ) ) {
									$count = count( $actions_count );
								}
								if ( $count > 0 ) {
									echo '<span class="badge-action-count">' . esc_html( $count ) . '</span>';
								}
							}
							echo '</a>';
						}
					}

					echo '</h2>';

					/* Display content for current tab */
					if ( method_exists( $this, $active_tab ) ) {
						$this->$active_tab();
					}
				}// End if().

				echo '</div><!--/.wrap.about-wrap-->';
			}// End if().
		}

		/**
		 * Call plugin api
		 */
		public function call_plugin_api( $slug ) {
			include_once(ABSPATH . 'wp-admin/includes/plugin-install.php');

			$call_api = get_transient( 'ti_about_plugin_info_' . $slug );

			if ( false === $call_api ) {
				$call_api = plugins_api(
					'plugin_information', array(
						'slug'   => $slug,
						'fields' => array(
							'downloaded'        => false,
							'rating'            => false,
							'description'       => false,
							'short_description' => true,
							'donate_link'       => false,
							'tags'              => false,
							'sections'          => true,
							'homepage'          => true,
							'added'             => false,
							'last_updated'      => false,
							'compatibility'     => false,
							'tested'            => false,
							'requires'          => false,
							'downloadlink'      => false,
							'icons'             => true,
						),
					)
				);
				set_transient( 'ti_about_plugin_info_' . $slug, $call_api, 30 * MINUTE_IN_SECONDS );
			}

			return $call_api;
		}

		/**
		 * Check if plugin is active
		 *
		 * @param plugin-slug $slug the plugin slug.
		 * @return array
		 */
		public function check_if_plugin_active( $slug ) {
			if ( ( $slug == 'intergeo-maps' ) || ( $slug == 'visualizer' ) ) {
				$plugin_root_file = 'index';
			} elseif ( $slug == 'adblock-notify-by-bweb' ) {
				$plugin_root_file = 'adblock-notify';
			}
            elseif ( $slug == 'contact-form-7' ) {
                $plugin_root_file = 'wp-contact-form-7';
            }
			else {
				$plugin_root_file = $slug;
			}

			$path = WPMU_PLUGIN_DIR . '/' . $slug . '/' . $plugin_root_file . '.php';
			if ( ! file_exists( $path ) ) {
				$path = WP_PLUGIN_DIR . '/' . $slug . '/' . $plugin_root_file . '.php';
				if ( ! file_exists( $path ) ) {
					$path = false;
				}
			}

			if ( file_exists( $path ) ) {

				include_once(ABSPATH . 'wp-admin/includes/plugin.php');

				$needs = is_plugin_active( $slug . '/' . $plugin_root_file . '.php' ) ? 'deactivate' : 'activate';

				return array(
					'status' => is_plugin_active( $slug . '/' . $plugin_root_file . '.php' ),
					'needs'  => $needs,
				);
			}

			return array(
				'status' => false,
				'needs'  => 'install',
			);
		}

		/**
		 * Get icon of wordpress.org plugin
		 *
		 * @param array $arr array of image formats.
		 *
		 * @return mixed
		 */
		public function get_plugin_icon( $arr ) {

			if ( ! empty( $arr['svg'] ) ) {
				$plugin_icon_url = $arr['svg'];
			} elseif ( ! empty( $arr['2x'] ) ) {
				$plugin_icon_url = $arr['2x'];
			} elseif ( ! empty( $arr['1x'] ) ) {
				$plugin_icon_url = $arr['1x'];
			} else {
				$plugin_icon_url = get_template_directory_uri() . '/information/hl-notifications/hl-about-page/images/placeholder_plugin.png';
			}

			return $plugin_icon_url;
		}

		/**
		 * Check if a slug is from intergeo, visualizer or adblock and returns the correct slug for them.
		 *
		 * @param string $slug Plugin slug.
		 *
		 * @return string
		 */
		public function check_plugin_slug( $slug ) {
			switch ( $slug ) {
				case 'intergeo-maps':
				case 'visualizer':
					$slug = 'index';
					break;
				case 'adblock-notify-by-bweb':
					$slug = 'adblock-notify';
					break;
			}
			return $slug;
		}

		/**
		 * Display button for recommended actions or
		 *
		 * @param array $data Data for an item.
		 */
		public function display_button( $data ) {
			$button_new_tab = '_self';
			$button_class   = '';
			if ( isset( $tab_data['is_new_tab'] ) ) {
				if ( $data['is_new_tab'] ) {
					$button_new_tab = '_blank';
				}
			}

			if ( $data['is_button'] ) {
				$button_class = 'button button-primary';
			}
			echo '<a target="' . $button_new_tab . '" href="' . $data['button_link'] . '"class="' . esc_attr( $button_class ) . '">' . $data['button_label'] . '</a>';
		}

		/**
		 * Getting started tab
		 */
		public function getting_started() {

			if ( ! empty( $this->config['getting_started'] ) ) {

				$getting_started = $this->config['getting_started'];

				if ( ! empty( $getting_started ) ) {

					echo '<div class="feature-section three-col">';

					foreach ( $getting_started as $getting_started_item ) {

						echo '<div class="col">';
						if ( ! empty( $getting_started_item['title'] ) ) {
							echo '<h3>' . $getting_started_item['title'] . '</h3>';
						}
						if ( ! empty( $getting_started_item['text'] ) ) {
							echo '<p>' . $getting_started_item['text'] . '</p>';
						}
						if ( ! empty( $getting_started_item['button_link'] ) && ! empty( $getting_started_item['button_label'] ) ) {

							echo '<p>';

							$count = 0;

							$actions_count = $this->get_required_actions();

							if ( ! empty( $actions_count ) ) {
								$count = count( $actions_count );
							}

							if ( $getting_started_item['recommended_actions'] && isset( $count ) ) {
								if ( $count == 0 ) {
									echo '<span class="dashicons dashicons-yes"></span>';
								} else {
									echo '<span class="dashicons dashicons-no-alt"></span>';
								}
							}
							$this->display_button( $getting_started_item );
							echo '</p>';
						}

						echo '</div><!-- .col -->';
					}// End foreach().
					echo '</div><!-- .feature-section three-col -->';
				}// End if().
			}// End if().
		}


        public function demo_import()
        {
            if (in_array('one-click-demo-import/one-click-demo-import.php', apply_filters('active_plugins', get_option('active_plugins')))) {

                echo '<div class="theme-browser rendered">';
                echo '<div class="themes wp-clearfix">';

                if (!empty($this->config['demo_import'])) {
                    $support_steps = $this->config['demo_import'];
                    if (!empty($support_steps)) {

                        foreach ($support_steps as $support_step) {
                            echo '<div class="theme" tabindex="0">';
                            if ($support_step['is_free_pro'] == 'free')
                                echo '<div class="ngo-charity-lite-ribbon ngo-charity-lite-free"></div>';
                            else
                                echo '<div class="ngo-charity-lite-ribbon ngo-charity-lite-pro"></div>';
                            echo '<div class="theme-screenshot">';
                            echo '<img src="' . esc_url($support_step['image']) . '" alt="">';
                            echo '</div>';
                            echo '<div class="theme-id-container">';
                            echo '<h2 class="theme-name">' . esc_html($support_step['title']) . '</h2>';
                            echo '<div class="theme-actions">';
                            echo '<a class="button" href="' . esc_html($support_step['demo_link']) . '" target="_blank">' . esc_html($support_step['demo_label']) . '</a>';
                            echo '<a class="button button-primary" href="' . esc_html($support_step['buy_link']) . '" target="_blank">' . esc_html($support_step['buy_label']) . '</a>';
                            echo '</div>';
                            echo '</div>';
                            echo '</div>';
                        }// End foreach().
                    }// End if().
                }// End if().

                echo '</div>';
                echo '</div>';

            }
            else{
                echo '<div class="theme-browser rendered">';
                echo '<div class="themes wp-clearfix">';
                echo sprintf( wp_kses( __( 'Please Install One Click Demo Import Plugin For Demos. <a href="%s">Download Here.</a>', 'ngo-charity-lite' ), array(  'a' => array( 'href' => array() ) ) ), esc_url( 'https://wordpress.org/plugins/one-click-demo-import/' ) );
                echo '</div>';
                echo '</div>';
            }
        }


        /**
		 * Recommended Actions tab
		 */
		public function recommended_actions() {

			$recommended_actions = isset( $this->config['recommended_actions'] ) ? $this->config['recommended_actions'] : array();

			if ( ! empty( $recommended_actions ) ) {

				echo '<div class="feature-section action-required demo-import-boxed" id="plugin-filter">';

				$actions     = array();
				$req_actions = isset( $this->config['recommended_actions'] ) ? $this->config['recommended_actions'] : array();
				foreach ( $req_actions['content'] as $req_action ) {
					$actions[] = $req_action;
				}

				if ( ! empty( $actions ) && is_array( $actions ) ) {

					$ti_about_page_show_required_actions = get_option( $this->theme_slug . '_required_actions' );



					foreach ( $actions as $action_key => $action_value ) {

						$hidden = false;

						if ( $ti_about_page_show_required_actions[ $action_value['id'] ] === false ) {
							$hidden = true;
						}
						if ( $action_value['check'] ) {
							continue;
						}
                        echo '<div class="hl-about-page-action-required-box">';

						$this->display_feature_title_and_description( $action_value );

						if ( ! empty( $action_value['plugin_slug'] ) ) {

							$active = $this->check_if_plugin_active( $action_value['plugin_slug'] );
							$label  = '';
							$slug   = $this->check_plugin_slug( $action_value['plugin_slug'] );
							$url    = ngo_charity_lite_create_action_link( $active['needs'], $slug );


							switch ( $active['needs'] ) {

								case 'install':
									$class = 'install-now button';
									if ( ! empty( $this->config['recommended_actions']['install_label'] ) ) {
										$label = $this->config['recommended_actions']['install_label'];
									}
									break;
								case 'activate':
									$class = 'activate-now button button-primary';
									if ( ! empty( $this->config['recommended_actions']['activate_label'] ) ) {
										$label = $this->config['recommended_actions']['activate_label'];
									}
									break;
								case 'deactivate':
									$class = 'deactivate-now button';
									if ( ! empty( $this->config['recommended_actions']['deactivate_label'] ) ) {
										$label = $this->config['recommended_actions']['deactivate_label'];
									}
									break;
							}

							?>
							<p class="plugin-card-<?php echo esc_attr( $action_value['plugin_slug'] ); ?> action_button <?php echo ( $active['needs'] !== 'install' && $active['status'] ) ? 'active' : ''; ?>">
								<a data-slug="<?php echo esc_attr( $action_value['plugin_slug'] ); ?>" class="<?php echo esc_attr( $class ); ?>" href="<?php echo esc_url( $url ); ?>"> <?php echo esc_html( $label ); ?> </a>
							</p>

							<?php

						}// End if().
						echo '</div>';
					}// End foreach().
				}// End if().
				echo '</div>';
			}// End if().
		}

		/**
		 * Recommended plugins tab
		 */
		public function recommended_plugins() {
			$recommended_plugins = $this->config['recommended_plugins'];

            if ( ! empty( $recommended_plugins ) ) {
				if ( ! empty( $recommended_plugins['content'] ) && is_array( $recommended_plugins['content'] ) ) {

					echo '<div class="feature-section recommended-plugins three-col demo-import-boxed" id="plugin-filter">';

					foreach ( $recommended_plugins['content'] as $recommended_plugins_item ) {

						if ( ! empty( $recommended_plugins_item['slug'] ) ) {
							$info = $this->call_plugin_api( $recommended_plugins_item['slug'] );

							if ( ! empty( $info->icons ) ) {
								$icon = $this->get_plugin_icon( $info->icons );
							}

							$active = $this->check_if_plugin_active( $recommended_plugins_item['slug'] );
							if ( ! empty( $active['needs'] ) ) {
								$slug = $this->check_plugin_slug( $recommended_plugins_item['slug'] );
								$url  = ngo_charity_lite_create_action_link( $active['needs'], $slug );
							}

							echo '<div class="col plugin_box">';
							if ( ! empty( $icon ) ) {
								echo '<img src="' . esc_url( $icon ) . '" alt="plugin box image">';
							}
							if ( ! empty( $info->name ) && ! empty( $active ) ) {
								echo '<div class="title-action-wrapper">';
								echo '<div class="action_bar ' . ( ( $active['needs'] !== 'install' && $active['status'] ) ? 'active' : '' ) . '">';
								echo '<span class="plugin_name">' . esc_html( $info->name ) . '</span>';
								echo '</div>';

								$label = '';

								switch ( $active['needs'] ) {
									case 'install':
										$class = 'install-now button';
										if ( ! empty( $this->config['recommended_plugins']['install_label'] ) ) {
											$label = $this->config['recommended_plugins']['install_label'];
										}
										break;
									case 'activate':
										$class = 'activate-now button button-primary';
										if ( ! empty( $this->config['recommended_plugins']['activate_label'] ) ) {
											$label = $this->config['recommended_plugins']['activate_label'];
										}
										break;
									case 'deactivate':
										$class = 'deactivate-now button';
										if ( ! empty( $this->config['recommended_plugins']['deactivate_label'] ) ) {
											$label = $this->config['recommended_plugins']['deactivate_label'];
										}
										break;
								}

								echo '<span class="plugin-card-' . esc_attr( $recommended_plugins_item['slug'] ) . ' action_button ' . ( ( $active['needs'] !== 'install' && $active['status'] ) ? 'active' : '' ) . '">';
								echo '<a data-slug="' . esc_attr( $recommended_plugins_item['slug'] ) . '" class="' . esc_attr( $class ) . '" href="' . esc_url( $url ) . '">' . esc_html( $label ) . '</a>';
								echo '</span>';
								echo '</div>';
							}
							if ( ! empty( $info->version ) || ! empty( $info->author ) ) {
							?>
								<div class="version-wrapper">
							<?php
							}
							if ( ! empty( $info->version ) ) {
								echo '<span class="version">' . ( ! empty( $this->config['recommended_plugins']['version_label'] ) ? esc_html( $this->config['recommended_plugins']['version_label'] ) : '' ) . esc_html( $info->version ) . '</span>';
							}
							if ( ! empty( $info->author ) ) {
								echo '<span class="separator"> | </span>' . wp_kses_post( strip_tags( $info->author ) );
							}
							if ( ! empty( $info->version ) || ! empty( $info->author ) ) {
							?>
								</div>
							<?php
							}

							echo '</div><!-- .col.plugin_box -->';
						}// End if().
					}// End foreach().

					echo '</div><!-- .recommended-plugins -->';

				}// End if().
			}// End if().
		}

		/**
		 * Child themes
		 */
		public function child_themes() {
			echo '<div id="child-themes" class="hl-about-page-tab-pane">';
			$child_themes = isset( $this->config['child_themes'] ) ? $this->config['child_themes'] : array();
			if ( ! empty( $child_themes ) ) {
				if ( ! empty( $child_themes['content'] ) && is_array( $child_themes['content'] ) ) {
					echo '<div class="hl-about-row">';
					for ( $i = 0; $i < count( $child_themes['content'] ); $i ++ ) {
						if ( ( $i !== 0 ) && ( $i / 3 === 0 ) ) {
							echo '</div>';
							echo '<div class="hl-about-row">';
						}
						$child = $child_themes['content'][ $i ];
						if ( ! empty( $child['image'] ) ) {
							echo '<div class="hl-about-child-theme">';
							echo '<div class="hl-about-page-child-theme-image">';
							echo '<img src="' . esc_url( $child['image'] ) . '" alt="' . ( ! empty( $child['image_alt'] ) ? esc_html( $child['image_alt'] ) : '' ) . '" />';
							if ( ! empty( $child['title'] ) ) {
								echo '<div class="hl-about-page-child-theme-details">';
								if ( $child['title'] != $this->theme_name ) {
									echo '<div class="theme-details">';
									echo '<span class="theme-name">' . $child['title'] . '</span>';
									if ( ! empty( $child['download_link'] ) && ! empty( $child_themes['download_button_label'] ) ) {
										echo '<a href="' . esc_url( $child['download_link'] ) . '" class="button button-primary install right">' . esc_html( $child_themes['download_button_label'] ) . '</a>';
									}
									if ( ! empty( $child['preview_link'] ) && ! empty( $child_themes['preview_button_label'] ) ) {
										echo '<a class="button button-secondary preview right" target="_blank" href="' . $child['preview_link'] . '">' . esc_html( $child_themes['preview_button_label'] ) . '</a>';
									}
									echo '</div>';
								}
								echo '</div>';
							}
							echo '</div><!--hl-about-page-child-theme-image-->';
							echo '</div><!--hl-about-child-theme-->';
						}// End if().
					}// End for().
					echo '</div>';
				}// End if().
			}// End if().
			echo '</div>';
		}

		/**
		 * Support tab
		 */
		public function support() {
			echo '<div class="feature-section three-col">';

			if ( ! empty( $this->config['support_content'] ) ) {

				$support_steps = $this->config['support_content'];

				if ( ! empty( $support_steps ) ) {

					foreach ( $support_steps as $support_step ) {

						echo '<div class="col">';

						if ( ! empty( $support_step['title'] ) ) {
							echo '<h3>';
							if ( ! empty( $support_step['icon'] ) ) {
								echo '<i class="' . $support_step['icon'] . '"></i>';
							}
							echo $support_step['title'];
							echo '</h3>';
						}

						if ( ! empty( $support_step['text'] ) ) {
							echo '<p><i>' . $support_step['text'] . '</i></p>';
						}

						if ( ! empty( $support_step['button_link'] ) && ! empty( $support_step['button_label'] ) ) {
							echo '<p>';
							$this->display_button( $support_step );
							echo '</p>';
						}

						echo '</div>';

					}// End foreach().
				}// End if().
			}// End if().

			echo '</div>';
		}

		/**
		 * Changelog tab
		 */
		public function changelog() {
			$changelog = $this->parse_changelog();
			if ( ! empty( $changelog ) ) {
				echo '<div class="featured-section changelog">';
				foreach ( $changelog as $release ) {
					if ( ! empty( $release['title'] ) ) {
						echo '<h2>' . $release['title'] . ' </h2 > ';
					}
					if ( ! empty( $release['changes'] ) ) {
						echo implode( '<br/>', $release['changes'] );
					}
				}
				echo '</div><!-- .featured-section.changelog -->';
			}
		}

		/**
		 * Return the releases changes array.
		 *
		 * @return array The releases array.
		 */
		private function parse_changelog() {
			WP_Filesystem();
			global $wp_filesystem;
			$changelog = $wp_filesystem->get_contents( get_template_directory() . '/CHANGELOG.md' );
			if ( is_wp_error( $changelog ) ) {
				$changelog = '';
			}
			$changelog = explode( PHP_EOL, $changelog );
			$releases  = array();
			foreach ( $changelog as $changelog_line ) {
				if ( strpos( $changelog_line, '**Changes:**' ) !== false || empty( $changelog_line ) ) {
					continue;
				}
				if ( substr( $changelog_line, 0, 3 ) === '###' ) {
					if ( isset( $release ) ) {
						$releases[] = $release;
					}
					$release = array(
						'title'   => substr( $changelog_line, 3 ),
						'changes' => array(),
					);
				} else {
					$release['changes'][] = $changelog_line;
				}
			}

			return $releases;
		}

		/**
		 * Display feature title and description
		 *
		 * @param array $feature Feature data.
		 */
		public function display_feature_title_and_description( $feature ) {
			if ( ! empty( $feature['title'] ) ) {
				echo '<h3>' . wp_kses_post( $feature['title'] ) . '</h3>';
			}
			if ( ! empty( $feature['description'] ) ) {
				echo '<p>' . wp_kses_post( $feature['description'] ) . '</p>';
			}
		}

		/**
		 * Load css and scripts for the about page
		 */
		public function style_and_scripts( $hook_suffix ) {

			// this is needed on all admin pages, not just the about page, for the badge action count in the WordPress main sidebar
			wp_enqueue_style( 'hl-about-page-css', get_template_directory_uri() . '/information/ngo-charity-lite-about-page/css/ngo_charity_lite_about_page_css.css', array(), NGO_CHARITY_LITE_VERSION );

			if ( 'appearance_page_' . $this->theme_slug . '-welcome' == $hook_suffix ) {

				wp_enqueue_script( 'hl-about-page-js', get_template_directory_uri() . '/information/ngo-charity-lite-about-page/js/ngo_charity_lite_about_page_scripts.js', array( 'jquery' ), NGO_CHARITY_LITE_VERSION );

				wp_enqueue_style( 'plugin-install' );
				wp_enqueue_script( 'plugin-install' );
				wp_enqueue_script( 'updates' );

				$recommended_actions = isset( $this->config['recommended_actions'] ) ? $this->config['recommended_actions'] : array();
				$required_actions    = $this->get_required_actions();
				wp_localize_script(
					'hl-about-page-js', 'tiAboutPageObject', array(
						'nr_actions_required' => count( $required_actions ),
						'ajaxurl'             => admin_url( 'admin-ajax.php' ),
						'template_directory'  => get_template_directory_uri(),
						'activating_string'   => esc_html__( 'Activating', 'ngo-charity-lite' ),
					)
				);

			}

		}

		/**
		 * Return the valid array of required actions.
		 *
		 * @return array The valid array of required actions.
		 */
		private function get_required_actions() {
			$saved_actions = get_option( $this->theme_slug . '_required_actions' );
			if ( ! is_array( $saved_actions ) ) {
				$saved_actions = array();
			}
			$req_actions = isset( $this->config['recommended_actions'] ) ? $this->config['recommended_actions'] : array();
			$valid       = array();
			foreach ( $req_actions['content'] as $req_action ) {
				if ( ( ! isset( $req_action['check'] ) || ( isset( $req_action['check'] ) && ( $req_action['check'] == false ) ) ) && ( ! isset( $saved_actions[ $req_action['id'] ] ) ) ) {
					$valid[] = $req_action;
				}
			}

			return $valid;
		}

		/**
		 * Dismiss required actions
		 */
		public function dismiss_required_action_callback() {

			$recommended_actions = array();
			$req_actions         = isset( $this->config['recommended_actions'] ) ? $this->config['recommended_actions'] : array();
			foreach ( $req_actions['content'] as $req_action ) {
				$recommended_actions[] = $req_action;
			}

			$action_id = ( isset( $_GET['id'] ) ) ? $_GET['id'] : 0;

			echo esc_html( wp_unslash( $action_id ) ); /* this is needed and it's the id of the dismissable required action */

			if ( ! empty( $action_id ) ) {

				/* if the option exists, update the record for the specified id */
				if ( get_option( $this->theme_slug . '_required_actions' ) ) {

					$ti_about_page_show_required_actions = get_option( $this->theme_slug . '_required_actions' );

					switch ( esc_html( $_GET['todo'] ) ) {
						case 'add':
							$ti_about_page_show_required_actions[ absint( $action_id ) ] = true;
							break;
						case 'dismiss':
							$ti_about_page_show_required_actions[ absint( $action_id ) ] = false;
							break;
					}

					update_option( $this->theme_slug . '_required_actions', $ti_about_page_show_required_actions );

					/* create the new option,with false for the specified id */
				} else {

					$ti_about_page_show_required_actions_new = array();

					if ( ! empty( $recommended_actions ) ) {

						foreach ( $recommended_actions as $ti_about_page_required_action ) {

							if ( $ti_about_page_required_action['id'] == $action_id ) {
								$ti_about_page_show_required_actions_new[ $ti_about_page_required_action['id'] ] = false;
							} else {
								$ti_about_page_show_required_actions_new[ $ti_about_page_required_action['id'] ] = true;
							}
						}

						update_option( $this->theme_slug . '_required_actions', $ti_about_page_show_required_actions_new );

					}
				}
			}// End if().
		}

	}
}// End if().
