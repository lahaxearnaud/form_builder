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
                    Ui::ACTION => site_url('ctrl/fct'),
                ), false );

                $this->form_builder->build(array(
                    array (
                        Ui::TYPE => Ui::TEXT,
                        Ui::NAME => 'champs1',
                        Ui::LABEL => 'CHAMPS 1',
                        Ui::SUFFIX => 'HOP',
                        Ui::PREFIX => 'HEP',

                    ),

                    array (
                        Ui::TYPE => Ui::SELECT,
                        Ui::LABEL => "SELECT",
                        Ui::NAME => 'champs2',
                        Ui::OPTIONS => array(
                            1 => 'UN',
                            2 => 'DEUX'
                        ),
                        UI::HELP => 'i am an help'
                    ),

                    array (
                        Ui::TYPE => Ui::PASSWORD,
                        Ui::NAME => 'pass',
                        Ui::LABEL => 'CHAMPS 2'
                    ),

                    array(
                        Ui::TYPE => Ui::RADIOGROUP,
                        Ui::NAME => 'RADIO',
                        Ui::LABEL => 'MES RADIOS',
                        Ui::OPTIONS => array(
                            array(
                                Ui::VALUE => '1',
                                Ui::LABEL => '1'
                            ),
                            array(
                                Ui::VALUE => '2',
                                Ui::LABEL => '2'
                            ),
                            array(
                                Ui::VALUE => '3',
                                Ui::LABEL => '3'
                            ),
                        )
                    ),

                    array(
                        Ui::TYPE => Ui::CHECKBOXGROUP,
                        Ui::NAME => 'CHECKBOX',
                        Ui::LABEL => 'MES CHECKBOX',
                        Ui::OPTIONS => array(
                            array(
                                Ui::VALUE => '1',
                                Ui::LABEL => '1'
                            ),
                            array(
                                Ui::VALUE => '2',
                                Ui::LABEL => '2'
                            ),
                            array(
                                Ui::VALUE => '3',
                                Ui::LABEL => '3'
                            ),
                        )
                    ),

                    array (
                        Ui::TYPE => Ui::TEXTAREA,
                        Ui::NAME => 'champs11',
                        Ui::LABEL => 'CHAMPS 1'
                    ),

                    array (
                        Ui::TYPE => Ui::FILE,
                        Ui::NAME => 'champs12',
                        Ui::LABEL => 'CHAMPS 1'
                    ),

                    array (
                        Ui::TYPE => Ui::HIDDEN,
                        Ui::NAME => 'champs13',
                        UI::VALUE => 'HEY'
                    ),

                    array (
                        Ui::TYPE => Ui::COMBINE,
                        UI::OPTIONS => array(
                            array(
                                Ui::TYPE => Ui::SUBMIT,
                                Ui::NAME => 'champs14',
                                UI::VALUE => 'Envoyer'
                            ),

                            array(
                                Ui::TYPE => Ui::LINK,
                                Ui::HTML => 'champs15',
                                UI::HREF => '#',
                                Ui::CLASSES => 'btn btn-warning'
                            ),
                        )
                    ),
                ));

                echo $this->form_builder;


            }

        }

        /* End of file welcome.php */
        /* Location: ./application/controllers/welcome.php */