form_builder
============

CodeIgniter form builder with Bootstrap, foundation or PureCss framework

Initialization
==============

$this->load->library('form_builder');

Configuration
==============

In config/form_builder.php set $config['defaultCSSFwk'] to your favorite Css framwork in Bootstrap, Foundation or PureCss

Usage
==============

Configure the form_builder for the current form :
-----

$this->form_builder->config( array(
    Ui::ACTION => site_url('ctrl/fct'),
), false );


Configure fields of the form
-----

$this->form_builder->build(array(
                    array (
                        Ui::TYPE => Ui::TEXT,
                        Ui::NAME => 'champs1',
                        Ui::LABEL => 'CHAMPS 1',
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
                        UI::HELP => 'Je suis une aide à la con'
                    ),

                    array (
                        Ui::TYPE => Ui::PASSWORD,
                        Ui::NAME => 'pass',
                        Ui::LABEL => 'CHAMPS 2',
                        Ui::SUFFIX => 'HOP',

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

Retreive the HTML of the form :
-----

echo $this->form_builder 

OR

$html = $this->form_builder->render();


Easy isn't it ?!


More usage
==============


Add a element :
-----

$this->form_builder->add(array (
                        Ui::TYPE => Ui::TEXT,
                        Ui::NAME => 'champs1',
                        Ui::LABEL => 'CHAMPS 1',
                        Ui::PREFIX => 'HEP',

                    ));


Get an element :
-----

$arrayElement = $this->form_builder->get ( $nameOfField);

Render an element :
-----
$this->form_builder->renderElement(array (
                        Ui::TYPE => Ui::TEXT,
                        Ui::NAME => 'champs1',
                        Ui::LABEL => 'CHAMPS 1',
                        Ui::PREFIX => 'HEP',

                    ));



Developed by LAHAXE Arnaud