<?php

namespace EShop\Controllers;
use EShop\ViewModels\TestViewModel;

/**
 * @Route("pesho")
 */
class TestController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @Admin

     */
    public function index()
    {

        echo 'Index()';
    }

    public function testAjax()
    {
        $data = array(
            array("Name"=>"Abbot Coleman","Email"=>"ipsum.nunc.id@posuere.org"),
            array("Name"=>"Arden Nielsen","Email"=>"dolor.nonummy.ac@posuere.edu"),
            array("Name"=>"Macey M. Bowen","Email"=>"nec.ligula@Sedet.org"),
            array("Name"=>"Rhea Spence","Email"=>"gravida.Aliquam@vehicula.co.uk"),
            array("Name"=>"Rhona R. Daniels","Email"=>"a.malesuada.id@venenatislacus.ca"),
            array("Name"=>"Kellie Hudson","Email"=>"pellentesque@augue.org"),
            array("Name"=>"Alma Z. Norris","Email"=>"Sed.nec.metus@Etiamlaoreet.ca"),
            array("Name"=>"Slade Hanson","Email"=>"augue.porttitor@noncursusnon.edu"),
            array("Name"=>"Fatima Hurley","Email"=>"ligula.Nullam.feugiat@utpharetrased.edu"),
            array("Name"=>"Laurel U. Woodard","Email"=>"non@vel.net"),
            array("Name"=>"Lars Atkinson","Email"=>"faucibus@id.edu"),
            array("Name"=>"Wang L. Reilly","Email"=>"tortor.Nunc@euultricessit.co.uk"),
            array("Name"=>"Gretchen Stein","Email"=>"fringilla@Aliquamtincidunt.edu"),
            array("Name"=>"Hedy Y. Ortega","Email"=>"nunc.ullamcorper.eu@magnanec.net"),
            array("Name"=>"Hadley C. Drake","Email"=>"fermentum@Integer.co.uk"),
            array("Name"=>"Joan D. Allen","Email"=>"tempor@vitaesemper.edu"),
            array("Name"=>"Alan Boyer","Email"=>"Sed@accumsanlaoreetipsum.co.uk"),
            array("Name"=>"Kennan West","Email"=>"ipsum@tristiqueneque.net"),
            array("Name"=>"Bernard K. Williams","Email"=>"imperdiet.ullamcorper@Intinciduntcongue.ca"),
            array("Name"=>"Alan A. Taylor","Email"=>"dictum@orciPhasellusdapibus.org"),
            array("Name"=>"Dale N. Levine","Email"=>"bibendum.fermentum@Curabiturmassa.ca"),
            array("Name"=>"Selma T. Mcintyre","Email"=>"a.neque@egestas.com"),
            array("Name"=>"Demetria U. Sellers","Email"=>"nec.mollis@ametconsectetueradipiscing.com"),
            array("Name"=>"Margaret Conrad","Email"=>"sociis@Donec.co.uk"),
            array("Name"=>"Cherokee Madden","Email"=>"sociis@egetnisidictum.co.uk"),
            array("Name"=>"Fatima D. Castro","Email"=>"pede@vehicula.org"),
            array("Name"=>"Violet Delgado","Email"=>"dui@ipsumdolorsit.ca"),
            array("Name"=>"Leroy M. Byers","Email"=>"adipiscing.lobortis@Naminterdumenim.ca"),
            array("Name"=>"Colleen N. Yang","Email"=>"Sed.eu.nibh@mienimcondimentum.org"),
            array("Name"=>"Galvin Padilla","Email"=>"dolor@mauris.ca"),
            array("Name"=>"Mona Rush","Email"=>"montes.nascetur.ridiculus@idrisus.org"),
            array("Name"=>"Lisandra Harvey","Email"=>"sem.Nulla.interdum@non.com"),
            array("Name"=>"Tucker J. Duran","Email"=>"consequat.nec.mollis@liberoMorbiaccumsan.co.uk"),
            array("Name"=>"Kaseem Wynn","Email"=>"dolor.Fusce@mollisnoncursus.edu"),
            array("Name"=>"Aretha C. Moses","Email"=>"mollis.Integer@erat.co.uk"),
            array("Name"=>"Xavier P. Dixon","Email"=>"urna@elementumategestas.net"),
            array("Name"=>"Violet A. Wade","Email"=>"risus.Donec.egestas@placeratorcilacus.com"),
            array("Name"=>"Yael Ballard","Email"=>"a.facilisis@acarcu.ca"),
            array("Name"=>"Branden Stewart","Email"=>"adipiscing.elit.Etiam@mienimcondimentum.edu"),
            array("Name"=>"Kasimir C. Richard","Email"=>"cursus@mi.ca"),
            array("Name"=>"Judah Brennan","Email"=>"lorem.lorem.luctus@nasceturridiculusmus.com"),
            array("Name"=>"Riley Mullen","Email"=>"Donec@fringillaeuismodenim.net"),
            array("Name"=>"Aaron Burks","Email"=>"molestie.tellus@molestietellusAenean.org"),
            array("Name"=>"Odessa Hardin","Email"=>"diam@turpisegestasFusce.co.uk"),
            array("Name"=>"Gay A. Carroll","Email"=>"Nam.ac.nulla@eratvel.edu"),
            array("Name"=>"Daria Kelley","Email"=>"consectetuer@urnanec.net"),
            array("Name"=>"Rhona L. Hammond","Email"=>"aliquam@ornarefacilisis.org"),
            array("Name"=>"Ivy D. Avery","Email"=>"erat.in@euismodestarcu.edu"),
            array("Name"=>"Rina Q. Hatfield","Email"=>"luctus.aliquet.odio@amet.net"),
            array("Name"=>"Acton Rogers","Email"=>"Morbi.sit@orci.net"),
            array("Name"=>"Remedios Velasquez","Email"=>"suscipit.nonummy.Fusce@nequetellusimperdiet.org"),
            array("Name"=>"Mia Willis","Email"=>"quis.diam@AeneanmassaInteger.net"),
            array("Name"=>"Randall Hart","Email"=>"vulputate.velit.eu@Loremipsumdolor.net"),
            array("Name"=>"Hyacinth W. Montgomery","Email"=>"et@consectetueradipiscing.ca"),
            array("Name"=>"Howard Dale","Email"=>"lorem.semper.auctor@eulacusQuisque.ca"),
            array("Name"=>"Seth Nash","Email"=>"dictum.Phasellus.in@Namtempordiam.ca"),
            array("Name"=>"Yolanda Macias","Email"=>"orci.luctus.et@egestasligulaNullam.net"),
            array("Name"=>"Cleo Burks","Email"=>"mollis.Duis.sit@enimSuspendissealiquet.org"),
            array("Name"=>"Brendan Schultz","Email"=>"dolor.Fusce.mi@Etiamimperdietdictum.org"),
            array("Name"=>"Sean Shaffer","Email"=>"consectetuer@duiCraspellentesque.co.uk"),
            array("Name"=>"Alden Brock","Email"=>"Integer.vitae.nibh@duiFuscealiquam.edu"),
            array("Name"=>"Kennan O. Mays","Email"=>"sem.mollis.dui@dictum.com"),
            array("Name"=>"Rhoda L. Campbell","Email"=>"malesuada@leoelementumsem.edu"),
            array("Name"=>"Ahmed B. Norris","Email"=>"Maecenas.malesuada@molestie.org"),
            array("Name"=>"Daphne C. Burke","Email"=>"Cum@acorciUt.com"),
            array("Name"=>"Emmanuel Rodgers","Email"=>"ornare@famesacturpis.edu"),
            array("Name"=>"Lionel N. Warner","Email"=>"nostra.per.inceptos@dolorDonecfringilla.com"),
            array("Name"=>"Kaitlin D. Holt","Email"=>"nisl.sem@nuncQuisqueornare.com"),
            array("Name"=>"Marny Velez","Email"=>"sed.consequat.auctor@Aliquamrutrum.edu"),
            array("Name"=>"Shelly Deleon","Email"=>"cursus.diam.at@aliquet.edu"),
            array("Name"=>"Melyssa H. Bradshaw","Email"=>"eu@augue.edu"),
            array("Name"=>"Paki U. Todd","Email"=>"arcu@Proin.com"),
            array("Name"=>"Michael Riley","Email"=>"sagittis.Duis@feugiatnonlobortis.net"),
            array("Name"=>"Knox Payne","Email"=>"montes.nascetur@felis.com"),
            array("Name"=>"Eden Richardson","Email"=>"a.odio.semper@aliquet.net"),
            array("Name"=>"Dakota B. Hickman","Email"=>"porta.elit@Donecluctusaliquet.org"),
            array("Name"=>"Adrienne Rivera","Email"=>"non.lorem@dictumauguemalesuada.co.uk"),
            array("Name"=>"Eve Clements","Email"=>"egestas.hendrerit.neque@lectusantedictum.com"),
            array("Name"=>"Ella Trevino","Email"=>"Aliquam.fringilla.cursus@quamvel.ca"),
            array("Name"=>"Chava Gallegos","Email"=>"nec.ante@utaliquam.ca"),
            array("Name"=>"Regina Schwartz","Email"=>"rhoncus.id@turpis.co.uk"),
            array("Name"=>"Quemby Logan","Email"=>"est@sodales.com"),
            array("Name"=>"Jonas Duran","Email"=>"et.netus.et@pedemalesuadavel.ca"),
            array("Name"=>"Jin Jackson","Email"=>"et@egetdictumplacerat.edu"),
            array("Name"=>"Savannah R. Webb","Email"=>"in.faucibus@Curae.co.uk"),
            array("Name"=>"Nomlanga W. Sawyer","Email"=>"blandit@tellusNunclectus.org"),
            array("Name"=>"Yvonne G. Warren","Email"=>"augue.porttitor.interdum@diamlorem.edu"),
            array("Name"=>"Gay R. Rios","Email"=>"lectus.sit@euismodetcommodo.ca"),
            array("Name"=>"Rebekah S. Whitfield","Email"=>"In@nuncacmattis.com"),
            array("Name"=>"Brittany Farmer","Email"=>"eros@fringillaornare.ca"),
            array("Name"=>"Jaden L. Sharpe","Email"=>"tristique.senectus@imperdiet.ca"),
            array("Name"=>"Timothy X. Garza","Email"=>"Suspendisse.non.leo@convallisligula.co.uk"),
            array("Name"=>"Nigel Berry","Email"=>"Pellentesque.ultricies@condimentumeget.org"),
            array("Name"=>"Moana Q. Finley","Email"=>"Mauris@erosnon.com"),
            array("Name"=>"Guinevere G. Beck","Email"=>"sit.amet.faucibus@malesuadafames.net"),
            array("Name"=>"Calvin Powers","Email"=>"vel.turpis@tristiquesenectus.org"),
            array("Name"=>"Quamar K. Allison","Email"=>"sit@fringilla.net"),
            array("Name"=>"Sandra Hawkins","Email"=>"Praesent.luctus@ridiculusmus.org"),
            array("Name"=>"Ryan K. Chandler","Email"=>"dapibus.gravida.Aliquam@Integertincidunt.edu"),
            array("Name"=>"Vera V. Mcclure","Email"=>"fermentum@libero.ca")
        );
        $limit = $_POST['limit'];       // coming from ajax
        $viewModel = new TestViewModel();
        $viewModel->testArr = array_slice($data, count($data) - $limit);
        $viewModel->render();
    }

    /**
     * @Editor
     * @Route("test2")
     */
    public function index2()
    {
        echo 'Index2()';
    }
}