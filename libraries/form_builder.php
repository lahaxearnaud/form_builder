<?php
/**
 *
 *
 *
 * @package        CodeIgniter
 * @subpackage     Auth
 * @category       type
 * @author         LAHAXE Arnaud
 *
 * @changelog
 *
 * 26 nov. 2013 LAHAXE Arnaud <lahaxe.arnaud@gmail.com>
 *      Initial Version
 */
class Ui
{
    const SELECT        = 'dropdown';
    const CHECKBOX      = 'checkbox';
    const CHECKBOXGROUP = 'checkboxGroup';
    const RADIOGROUP    = 'radioGroup';
    const TEXT          = 'text';
    const HIDDEN        = 'hidden';
    const PASSWORD      = 'password';
    const TEXTAREA      = 'textarea';
    const LINK          = 'link';
    const TITLE         = 'title';
    const HTML          = 'html';
    const FILE          = 'file';
    const HREF          = 'href';
    const DATE          = 'date';
    const EMAIL         = 'email';
    const SUBMIT        = 'submit';
    const ELEMENTS      = 'elements';
    const COMBINE       = 'combine';
    const NAME          = 'name';
    const VALUE         = 'value';
    const CLASSES       = 'class';
    const ID            = 'id';
    const OPTIONS       = 'options';
    const PLACEHOLDER   = 'placeholder';
    const ACTION        = 'action';
    const METHOD        = 'method';
    const TYPE          = 'type';
    const GET           = 'get';
    const POST          = 'post';
    const LABEL         = 'label';
    const ROLE          = 'role';
    const MULTIPLE      = 'multiple';
    const SELECTED      = 'selected';
    const PREFIX        = 'prefix';
    const SUFFIX        = 'suffix';
    const HELP          = 'help';
    const ERROR         = 'error';
    const CSS_FRAMEWORK = 'css_framework';
    const BOOTSTRAP     = 'bootstrap';
    const FOUNDATION    = 'foundation';
    const PURECSS       = 'purecss';
    const DISABLED      = 'disabled';
}

/**
 *
 *
 *
 * @package        CodeIgniter
 * @subpackage     Auth
 * @category       libarie
 * @author         LAHAXE Arnaud
 *
 * @changelog
 *
 * 26 nov. 2013 LAHAXE Arnaud <lahaxe.arnaud@gmail.com>
 *      Initial Version
 */
class Form_builder
{

    /**
     * @var array list of config elements
     */
    private $elements = array ();

    /**
     * @var bool multipart form ?
     */
    private $multipart = FALSE;

    /**
     * @var array form configuration
     *
     * Ui::Action required
     */
    private $formConfig = array ();

    private $classes = array ();

    function __construct()
    {
        get_instance()->load->helper( 'form' );
        get_instance()->load->config( 'form_builder' );

    }

    /**
     * Set configuration
     *
     * @param array $config
     * @param bool  $multipart
     */
    public function config( $config = array (), $multipart = FALSE )
    {

        $this->reset();

        $this->multipart = $multipart;
        $config          = array_merge( array (
            Ui::CSS_FRAMEWORK => get_instance()->config->item( 'defaultCSSFwk' ),
            Ui::CLASSES       => ''
        ), $config );

        // load css classes
        $classes       = get_instance()->config->item( Ui::CSS_FRAMEWORK );
        $this->classes = $classes[ $config[ Ui::CSS_FRAMEWORK ] ];

        $config [ Ui::CLASSES ] .= $this->classes[ 'form' ];
        $this->formConfig = $config;
    }

    /**
     * Initialise some missing configuration such as name or id
     *
     *
     * @param $element element configuration
     *
     * @return mixed $element
     */
    private function init( $element )
    {

        $element = array_merge( array (
            Ui::NAME    => uniqid( 'name_' ),
            Ui::ID      => uniqid(),
            Ui::CLASSES => '',
            Ui::TITLE   => ''
        ), $element );

        // set class error
        if ( isset( $element[ Ui::ERROR ] ) ) {
            $element[ Ui::CLASSES ] .= ' error ';
        }

        // add class input if not button or link
        if ( !in_array( Ui::TYPE, array ( Ui::LINK, Ui::SUBMIT ) ) ) {
            if ( !empty( $this->classes[ 'input' ] ) && strpos( $element[ Ui::CLASSES ], $this->classes[ 'input' ] ) === FALSE ) {
                $element[ Ui::CLASSES ] .= $this->classes[ 'input' ];
            }
            // add btn and btn-default for bootstrap if necessary
        } elseif ( $this->formConfig[ Ui::CSS_FRAMEWORK ] === Ui::BOOTSTRAP ) {
            if ( strpos( $element[ Ui::CLASSES ], 'btn' ) === FALSE ) {
                $element[ Ui::CLASSES ] = 'btn';
            }

            if ( strpos( $element[ Ui::CLASSES ], 'btn-' ) === FALSE ) {
                $element[ Ui::CLASSES ] .= ' btn-default';
            }
        }

        return $element;
    }

    /**
     * Get an array on configuration fields and save it in the object
     *
     * @param $elements
     */
    public function build( $elements )
    {
        foreach ( $elements as $element ) {
            $element                                = $this->init( $element );
            $this->elements[ $element[ Ui::NAME ] ] = $element;
        }
    }

    /**
     * Add a field
     *
     * @param $element
     */
    public function add( $element )
    {
        $element                                = $this->init( $element );
        $this->elements[ $element[ Ui::NAME ] ] = $element;
    }

    /**
     *
     * Get a field
     *
     * @param $name name of the fields
     *
     * @return mixed
     */
    public function get( $name )
    {
        return $this->elements[ $name ];
    }

    /**
     * Render the beginning of the form <FORM> and the CSRF token
     * @return string
     */
    public function renderStart()
    {

        $action = $this->formConfig[ Ui::ACTION ];
        if ( !$this->multipart ) {
            return form_open( $action, $this->formConfig );
        } else {
            return form_open_multipart( $action, $this->formConfig );
        }
    }

    /**
     * Close the form
     * @return string
     */
    public function renderEnd()
    {
        return form_close();
    }

    /**
     * Render the fields of the form
     * @return string
     */
    private function renderBody()
    {
        $form = '';

        foreach ( $this->elements as $element ) {
            $form .= $this->renderElement( $element );
        }

        if ( isset( $this->classes[ 'fieldset' ] ) ) {
            $form = '<fieldset>' . $form . '</fieldset>';
        }

        return $form;
    }


    /**
     *
     * Add decoration to the field
     *
     * @param $html    html of the field
     * @param $element configuration of the field
     * @param $type    type of the fied
     * @param $wrap    wrap or not wrap (fals form group)
     *
     * @return string
     */
    private function prepareElement( $html, $element, $type, $wrap )
    {
        if ( $type !== Ui::HIDDEN ) {
            if ( strcasecmp( $this->formConfig[ Ui::CSS_FRAMEWORK ], Ui::BOOTSTRAP ) == 0 ) {

                if ( isset( $element[ Ui::SUFFIX ] ) ) {
                    $html .= '<span class="input-group-addon">' . $element[ Ui::SUFFIX ] . '</span>';
                }

                if ( isset( $element[ Ui::PREFIX ] ) ) {
                    $html = '<span class="input-group-addon">' . $element[ Ui::SUFFIX ] . '</span>' . $html;
                }
            }

            if ( $wrap ) {
                $html = $this->wrapElement( $html, !isset( $element[ Ui::LABEL ] ) ? $this->classes[ 'offset' ] : '', $element );
            }

            if ( isset( $element[ Ui::LABEL ] ) ) {

                $label = '';
                if ( isset( $this->classes[ 'labelWrapper' ] ) ) {
                    $label .= '<div class="' . $this->classes[ 'labelWrapper' ] . '">';
                }

                $label .= form_label( $element[ Ui::LABEL ], $element[ Ui::ID ], array (
                    Ui::CLASSES => $this->classes[ 'label' ]
                ) );

                if ( isset( $this->classes[ 'labelWrapper' ] ) ) {
                    $label .= '</div>';
                }

                $html = $label . $html;
            }

            if ( $wrap ) {
                $html = $this->wrapGroup( $html );
            }

        }

        return $html;
    }

    /**
     *
     * Render a field with label and wrappers
     *
     * @param      $element field configuration
     * @param bool $wrap    add wrapper ?
     *
     * @return string
     */
    public function renderElement( $element, $wrap = TRUE )
    {
        $html = '';
        $type = $element[ Ui::TYPE ];

        unset( $element[ Ui::TYPE ] );

        switch ( $type ) {
            case Ui::TEXT:
                $html .= form_input( $element );
                break;

            case Ui::SELECT:
                if ( !isset( $element[ Ui::SELECTED ] ) ) {
                    $element[ Ui::SELECTED ] = array ();
                }
                $html .= form_dropdown( $element[ Ui::NAME ], $element[ Ui::OPTIONS ], $element[ Ui::SELECTED ], 'class="' . $element[ Ui::CLASSES ] . '"' );
                break;

            case Ui::HIDDEN:
                $html .= form_hidden( $element[ Ui::NAME ], $element[ Ui::VALUE ] );
                break;

            case Ui::SUBMIT:
                $html .= form_submit( $element );
                break;

            case Ui::TEXTAREA:
                $html .= form_textarea( $element );
                break;

            case Ui::PASSWORD:
                $html .= form_password( $element );
                break;

            case Ui::CHECKBOX:
                $html .= form_checkbox( $element );
                break;

            case Ui::FILE:
                $html .= form_upload( $element );
                break;

            case Ui::LINK:
                $html .= '<a class="' . $element[ Ui::CLASSES ] . '" href="' . $element[ Ui::HREF ] . '" title="' . $element[ Ui::TITLE ] . '" id="' . $element[ Ui::ID ] . '">' . $element[ Ui::HTML ] . '</a>';
                break;

            case Ui::COMBINE:
                foreach ( $element[ Ui::OPTIONS ] as $option ) {
                    $option = $this->init( $option );
                    $html .= $this->renderElement( $option, FALSE );
                }
                break;

            case Ui::RADIOGROUP:
                if ( is_array( $element[ Ui::OPTIONS ] ) ) {
                    foreach ( $element[ Ui::OPTIONS ] as $option ) {
                        $option[ Ui::NAME ] = $element[ Ui::NAME ] . '[]';
                        $option             = $this->init( $option );
                        $html .= '<label class="' . $this->classes[ 'radio' ] . '" for="' . $option[ Ui::ID ] . '">';
                        $html .= form_radio( $option );
                        if ( isset( $option[ Ui::LABEL ] ) ) {
                            $html .= ' ' . $option[ Ui::LABEL ] . ' ';
                        }
                        $html .= '</label>';
                    }
                } else {
                    $html .= form_radio( $element );
                }

                break;
            case Ui::CHECKBOXGROUP:
                if ( is_array( $element[ Ui::OPTIONS ] ) ) {
                    foreach ( $element[ Ui::OPTIONS ] as $option ) {
                        $option[ Ui::NAME ] = $element[ Ui::NAME ] . '[]';
                        $option             = $this->init( $option );
                        $html .= '<label  class="' . $this->classes[ 'checkbox' ] . '" for="' . $option[ Ui::ID ] . '">';
                        $html .= form_checkbox( $option );
                        if ( isset( $option[ Ui::LABEL ] ) ) {
                            $html .= ' ' . $option[ Ui::LABEL ] . ' ';
                        }
                        $html .= '</label>';
                    }
                } else {
                    $html .= form_checkbox( $element );
                }
                break;
            default:
                log_message( 'warning', 'Try to create an form element with a bad array' );
                continue;
                break;
        }

        $html = $this->prepareElement( $html, $element, $type, $wrap );

        return $html;
    }

    /**
     * Wrap an input
     *
     * @param        $htmlElement
     * @param string $classes
     * @param array  $element
     *
     * @return string
     */
    public function wrapElement( $htmlElement, $classes = '', $element = array () )
    {
        $help = '';
        if ( isset( $element[ Ui::HELP ] ) ) {
            $help = '<div class="' . $this->classes[ 'help' ] . '">' . $element[ Ui::HELP ] . '</div>';
        }

        return '<div class="' . $this->classes[ 'inputWrapper' ] . ' ' . $classes . '">' . $htmlElement . $help . '</div>';
    }

    /**
     * Wrap input and label group
     *
     * @param $htmlElement
     *
     * @return string
     */
    public function wrapGroup( $htmlElement )
    {
        return '<div class="' . $this->classes[ 'groupWrapper' ] . '">' . $htmlElement . '</div>';
    }


    /**
     * Generate HTML of the form
     * @return string
     */
    public function render()
    {
        return $this->renderStart() . $this->renderBody() . $this->renderEnd();

    }

    /**
     * alias for the render function
     * @return string
     */
    public function __toString()
    {
        return $this->render();
    }

    /**
     * reset the form builder
     */
    public function reset()
    {
        $this->elements  = array ();
        $this->multipart = FALSE;
    }
}
