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
class HTML
{
    const SELECT        = 'dropdown';
    const CHECKBOX      = 'checkbox';
    const CHECKBOXGROUP = 'checkboxGroup';
    const RADIOGROUP    = 'radioGroup';
    const RADIO         = 'radio';
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
     * HTML::Action required
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
            HTML::CSS_FRAMEWORK => get_instance()->config->item( 'defaultCSSFwk' ),
            HTML::CLASSES       => ''
        ), $config );

        // load css classes
        $classes       = get_instance()->config->item( HTML::CSS_FRAMEWORK );
        $this->classes = $classes[ $config[ HTML::CSS_FRAMEWORK ] ];

        $config [ HTML::CLASSES ] .= $this->classes[ 'form' ];
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
            HTML::NAME    => uniqid( 'name_' ),
            HTML::ID      => uniqid(),
            HTML::CLASSES => '',
            HTML::TITLE   => '',
        ), $element );

        // set class error
        if ( isset( $element[ HTML::ERROR ] ) ) {
            $element[ HTML::CLASSES ] .= ' error ';
        }
        
        // add class input if not button or link
        if ( !in_array( $element[ HTML::TYPE ], array ( HTML::LINK, HTML::SUBMIT ) ) ) {
            if ( !empty( $this->classes[ 'input' ] ) && strpos( $element[ HTML::CLASSES ], $this->classes[ 'input' ] ) === FALSE ) {
                $element[ HTML::CLASSES ] .= ' ' . $this->classes[ 'input' ];
            }
            // add btn and btn-default for bootstrap if necessary
        } elseif ( $this->formConfig[ HTML::CSS_FRAMEWORK ] === HTML::BOOTSTRAP ) {
            if ( strpos( $element[ HTML::CLASSES ], 'btn' ) === FALSE ) {
                $element[ HTML::CLASSES ] = 'btn';
            }

            if ( strpos( $element[ HTML::CLASSES ], 'btn-' ) === FALSE ) {
                $element[ HTML::CLASSES ] .= ' btn-default ';
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
            $this->elements[ $element[ HTML::NAME ] ] = $element;
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
        $this->elements[ $element[ HTML::NAME ] ] = $element;
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

        $action = $this->formConfig[ HTML::ACTION ];
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
        if ( $type !== HTML::HIDDEN ) {
            if ( strcasecmp( $this->formConfig[ HTML::CSS_FRAMEWORK ], HTML::BOOTSTRAP ) == 0 ) {

                if ( isset( $element[ HTML::SUFFIX ] ) ) {
                    $html .= '<span class="input-group-addon">' . $element[ HTML::SUFFIX ] . '</span>';
                }

                if ( isset( $element[ HTML::PREFIX ] ) ) {
                    $html = '<span class="input-group-addon">' . $element[ HTML::SUFFIX ] . '</span>' . $html;
                }
            }

            if ( $wrap ) {
                $html = $this->wrapElement( $html, !isset( $element[ HTML::LABEL ] ) ? $this->classes[ 'offset' ] : '', $element );
            }

            if ( isset( $element[ HTML::LABEL ] ) ) {

                $label = '';
                if ( isset( $this->classes[ 'labelWrapper' ] ) ) {
                    $label .= '<div class="' . $this->classes[ 'labelWrapper' ] . '">';
                }

                $label .= form_label( $element[ HTML::LABEL ], $element[ HTML::ID ], array (
                    HTML::CLASSES => $this->classes[ 'label' ]
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
        $type = $element[ HTML::TYPE ];

        unset( $element[ HTML::TYPE ] );

        switch ( $type ) {
            case HTML::TEXT:
                $html .= form_input( $element );
                break;

            case HTML::SELECT:
                if ( !isset( $element[ HTML::SELECTED ] ) ) {
                    $element[ HTML::SELECTED ] = array ();
                }
                $html .= form_dropdown( $element[ HTML::NAME ], $element[ HTML::OPTIONS ], $element[ HTML::SELECTED ], 'class="' . $element[ HTML::CLASSES ] . '"' );
                break;

            case HTML::HIDDEN:
                $html .= form_hidden( $element[ HTML::NAME ], $element[ HTML::VALUE ] );
                break;

            case HTML::SUBMIT:
                $html .= form_submit( $element );
                break;

            case HTML::TEXTAREA:
                $html .= form_textarea( $element );
                break;

            case HTML::PASSWORD:
                $html .= form_password( $element );
                break;

            case HTML::CHECKBOX:
                $html .= form_checkbox( $element );
                break;

            case HTML::FILE:
                $html .= form_upload( $element );
                break;

            case HTML::LINK:
                $html .= '<a class="' . $element[ HTML::CLASSES ] . '" href="' . $element[ HTML::HREF ] . '" title="' . $element[ HTML::TITLE ] . '" id="' . $element[ HTML::ID ] . '">' . $element[ HTML::HTML ] . '</a>';
                break;

            case HTML::COMBINE:
                foreach ( $element[ HTML::OPTIONS ] as $option ) {
                    $option = $this->init( $option );
                    $html .= $this->renderElement( $option, FALSE );
                }
                break;

            case HTML::RADIOGROUP:
                if ( is_array( $element[ HTML::OPTIONS ] ) ) {
                    foreach ( $element[ HTML::OPTIONS ] as $option ) {
                        $option[ HTML::NAME ] = $element[ HTML::NAME ] . '[]';
                        $option[ HTML::TYPE ] = HTML::RADIO;
                        $option             = $this->init( $option );
                        $html .= '<label class="' . $this->classes[ 'radio' ] . '" for="' . $option[ HTML::ID ] . '">';
                        $html .= form_radio( $option );
                        if ( isset( $option[ HTML::LABEL ] ) ) {
                            $html .= ' ' . $option[ HTML::LABEL ] . ' ';
                        }
                        $html .= '</label>';
                    }
                } else {
                    $html .= form_radio( $element );
                }

                break;
            case HTML::CHECKBOXGROUP:
                if ( is_array( $element[ HTML::OPTIONS ] ) ) {
                    foreach ( $element[ HTML::OPTIONS ] as $option ) {
                        $option[ HTML::NAME ] = $element[ HTML::NAME ] . '[]';
                        $option[ HTML::TYPE ] = HTML::CHECKBOX;
                        $option             = $this->init( $option );
                        $html .= '<label  class="' . $this->classes[ 'checkbox' ] . '" for="' . $option[ HTML::ID ] . '">';
                        $html .= form_checkbox( $option );
                        if ( isset( $option[ HTML::LABEL ] ) ) {
                            $html .= ' ' . $option[ HTML::LABEL ] . ' ';
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
        if ( isset( $element[ HTML::HELP ] ) ) {
            $help = '<div class="' . $this->classes[ 'help' ] . '">' . $element[ HTML::HELP ] . '</div>';
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
