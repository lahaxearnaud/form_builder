    <?php if ( !defined( 'BASEPATH' ) ) exit( 'No direct script access allowed' );

        class Example extends CI_Controller
        {

            function __construct()
            {
                parent::__construct();
            }


            public function index()
            {
                $this->load->library('form_builder');

                $this->form_builder->config( array(
                    HTML::ACTION => site_url('ctrl/fct'),
                ), false );

                $this->form_builder->build(array(
                    array (
                        HTML::TYPE => HTML::TEXT,
                        HTML::NAME => 'champs1',
                        HTML::LABEL => 'CHAMPS 1',
                        HTML::SUFFIX => 'HOP',
                        HTML::PREFIX => 'HEP',

                    ),

                    array (
                        HTML::TYPE => HTML::SELECT,
                        HTML::LABEL => "SELECT",
                        HTML::NAME => 'champs2',
                        HTML::OPTIONS => array(
                            1 => 'UN',
                            2 => 'DEUX'
                        ),
                        HTML::HELP => 'i am an help'
                    ),

                    array (
                        HTML::TYPE => HTML::PASSWORD,
                        HTML::NAME => 'pass',
                        HTML::LABEL => 'CHAMPS 2'
                    ),

                    array(
                        HTML::TYPE => HTML::RADIOGROUP,
                        HTML::NAME => 'RADIO',
                        HTML::LABEL => 'MES RADIOS',
                        HTML::OPTIONS => array(
                            array(
                                HTML::VALUE => '1',
                                HTML::LABEL => '1'
                            ),
                            array(
                                HTML::VALUE => '2',
                                HTML::LABEL => '2'
                            ),
                            array(
                                HTML::VALUE => '3',
                                HTML::LABEL => '3'
                            ),
                        )
                    ),

                    array(
                        HTML::TYPE => HTML::CHECKBOXGROUP,
                        HTML::NAME => 'CHECKBOX',
                        HTML::LABEL => 'MES CHECKBOX',
                        HTML::OPTIONS => array(
                            array(
                                HTML::VALUE => '1',
                                HTML::LABEL => '1'
                            ),
                            array(
                                HTML::VALUE => '2',
                                HTML::LABEL => '2'
                            ),
                            array(
                                HTML::VALUE => '3',
                                HTML::LABEL => '3'
                            ),
                        )
                    ),

                    array (
                        HTML::TYPE => HTML::TEXTAREA,
                        HTML::NAME => 'champs11',
                        HTML::LABEL => 'CHAMPS 1'
                    ),

                    array (
                        HTML::TYPE => HTML::FILE,
                        HTML::NAME => 'champs12',
                        HTML::LABEL => 'CHAMPS 1'
                    ),

                    array (
                        HTML::TYPE => HTML::HIDDEN,
                        HTML::NAME => 'champs13',
                        HTML::VALUE => 'HEY'
                    ),

                    array (
                        HTML::TYPE => HTML::COMBINE,
                        HTML::OPTIONS => array(
                            array(
                                HTML::TYPE => HTML::SUBMIT,
                                HTML::NAME => 'champs14',
                                HTML::VALUE => 'Envoyer'
                            ),

                            array(
                                HTML::TYPE => HTML::LINK,
                                HTML::HTML => 'champs15',
                                HTML::HREF => '#',
                                HTML::CLASSES => 'btn btn-warning'
                            ),
                        )
                    ),
                ));

                echo $this->form_builder;


            }

        }

        /* End of file welcome.php */
        /* Location: ./application/controllers/welcome.php */