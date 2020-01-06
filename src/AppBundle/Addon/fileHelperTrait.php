<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 2020/01/06
 * Time: 0:33
 */

namespace AppBundle\Addon;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use AppBundle\Entity\Event;
//use Doctrine\DBAL\Schema\Schema;
//use Doctrine\ORM\EntityManager;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;

use ZipArchive;

trait fileHelperTrait
{
    var $docFile  = '';
    var $title    = '';
    var $htmlHead = '';
    var $htmlBody = '';

    /**
     * Constructor
     *
     * @return void
     */
    function __construct(){
        $this->title = '';
        $this->htmlHead = '';
        $this->htmlBody = '';
    }

    /**
     * Set the document file name
     *
     * @param String $docfile
     */
    function setDocFileName($docfile){
        $this->docFile = $docfile;
        if(!preg_match("/\.doc$/i",$this->docFile) && !preg_match("/\.docx$/i",$this->docFile)){
            $this->docFile .= '.doc';
        }
        return;
    }

    /**
     * Set the document title
     *
     * @param String $title
     */
    function setTitle($title){
        $this->title = $title;
    }

    /**
     * Return header of MS Doc
     *
     * @return String
     */
    function getHeader(){
        $code = <<<"HEREDOC"
<html xmlns:v="urn:schemas-microsoft-com:vml" 
        xmlns:o="urn:schemas-microsoft-com:office:office" 
        xmlns:w="urn:schemas-microsoft-com:office:word"
        xmlns="http://www.w3.org/TR/REC-html40">     
        <head> 
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"> 
        <meta name="ProgId" content="Word.Document"> 
        <meta name="Generator" content="Microsoft Word 9"> 
        <meta name="Originator" content="Microsoft Word 9"> 
        <!--[if !mso]> 
        <style> 
        v\:* {behavior:url(#default#VML);} 
        o\:* {behavior:url(#default#VML);} 
        w\:* {behavior:url(#default#VML);} 
        .shape {behavior:url(#default#VML);} 
        </style> 
        <![endif]--> 
        <title>$this->title</title> 
        <!--[if gte mso 9]><xml> 
         <w:WordDocument> 
          <w:View>Print</w:View> 
          <w:DoNotHyphenateCaps/> 
          <w:PunctuationKerning/> 
          <w:DrawingGridHorizontalSpacing>9.35 pt</w:DrawingGridHorizontalSpacing> 
          <w:DrawingGridVerticalSpacing>9.35 pt</w:DrawingGridVerticalSpacing> 
         </w:WordDocument> 
        </xml><![endif]--> 
        <style> 
        <!-- 
         /* Font Definitions */ 
        @font-face 
            {font-family:"Times New Roman"; 
            panose-1:2 11 6 4 3 5 4 4 2 4; 
            mso-font-charset:0; 
            mso-generic-font-family:swiss; 
            mso-font-pitch:variable; 
            mso-font-signature:536871559 0 0 0 415 0;} 
         /* Style Definitions */ 
        p.MsoNormal, li.MsoNormal, div.MsoNormal 
            {mso-style-parent:""; 
            margin:0in; 
            margin-bottom:.0001pt; 
            mso-pagination:widow-orphan; 
            font-size: 14.0pt; 
                mso-bidi-font-size:12.0pt; 
            font-family:"Times New Roman"; 
            mso-fareast-font-family:"Verdana";} 
        p.small 
            {mso-style-parent:""; 
            margin:0in; 
            margin-bottom:.0001pt; 
            mso-pagination:widow-orphan; 
            font-size:10.0pt; 
                mso-bidi-font-size:10.0pt; 
            font-family:"Verdana"; 
            mso-fareast-font-family:"Verdana";} 
        @page Section1  
            {          
            mso-page-orientation:landscape;        
            size:29см 21см; 
            margin:3см 1.5см 1.5in 1.5in; 
            mso-header-margin:1.0см; 
            mso-footer-margin:1.0см; 
            mso-paper-source:0;            
            }        
           
        div.Section1 
            {page:Section1;} 
        --> 
        </style> 
        <!--[if gte mso 9]><xml> 
         <o:shapedefaults v:ext="edit" spidmax="1032"> 
          <o:colormenu v:ext="edit" strokecolor="none"/> 
         </o:shapedefaults></xml><![endif]--><!--[if gte mso 9]><xml> 
         <o:shapelayout v:ext="edit"> 
          <o:idmap v:ext="edit" data="1"/> 
         </o:shapelayout></xml><![endif]--> 
         $this->htmlHead
         </head>
         <body> 
HEREDOC;
        return $code;
    }

    /**
     * Return Document footer
     *
     * @return String
     */
    function getFotter(){
        return "</body></html>";
    }

    /**
     * Create The MS Word Document from given HTML
     *
     * @param String $html :: HTML Content or HTML File Name like path/to/html/file.html
     * @param String $file :: Document File Name
     * @param Boolean $download :: Wheather to download the file or save the file
     * @return boolean
     */
    function createDoc($html, $file, $download = false){
        if(is_file($html)){
            $html = @file_get_contents($html);
        }

        $this->_parseHtml($html);
        $this->setDocFileName($file);
        $doc = $this->getHeader();
        $doc .= $this->htmlBody;
        $doc .= $this->getFotter();

        if($download){
            @header("Cache-Control: ");// leave blank to avoid IE errors
            @header("Pragma: ");// leave blank to avoid IE errors
            @header("Content-type: application/octet-stream");
            @header("Content-Disposition: attachment; filename=\"$this->docFile\"");
            echo $doc;
            return true;
        }else {
            return $this->write_file($this->docFile, $doc);
        }
    }

    /**
     * Parse the html and remove <head></head> part if present into html
     *
     * @param String $html
     * @return void
     * @access Private
     */
    function _parseHtml($html){
        $html = preg_replace("/<!DOCTYPE((.|\n)*?)>/ims", "", $html);
        $html = preg_replace("/<script((.|\n)*?)>((.|\n)*?)<\/script>/ims", "", $html);
        preg_match("/<head>((.|\n)*?)<\/head>/ims", $html, $matches);
        $head = !empty($matches[1])?$matches[1]:'';
        preg_match("/<title>((.|\n)*?)<\/title>/ims", $head, $matches);
        $this->title = !empty($matches[1])?$matches[1]:'';
        $html = preg_replace("/<head>((.|\n)*?)<\/head>/ims", "", $html);
        $head = preg_replace("/<title>((.|\n)*?)<\/title>/ims", "", $head);
        $head = preg_replace("/<\/?head>/ims", "", $head);
        $html = preg_replace("/<\/?body((.|\n)*?)>/ims", "", $html);
        $this->htmlHead = $head;
        $this->htmlBody = $html;
        return;
    }

    /**
     * Write the content in the file
     *
     * @param String $file :: File name to be save
     * @param String $content :: Content to be write
     * @param [Optional] String $mode :: Write Mode
     * @return void
     * @access boolean True on success else false
     */
    function write_file($file, $content, $mode = "w"){
        $fp = @fopen($file, $mode);
        if(!is_resource($fp)){
            return false;
        }
        fwrite($fp, $content);
        fclose($fp);
        return true;
    }


    /*---------------------------------

    /**
     * * @param $print - output text
     * @IsGranted("ROLE_ADMIN")
     */
    public function printDoc($print)
    {
         // init file system
        $fsObject = new Filesystem();
        $current_dir_path = getcwd();
        $file_path = $current_dir_path . "\uploads\lists\list.html";

        try {
            if (!is_dir($current_dir_path)) {
                mkdir($current_dir_path);
                echo ("Directory ".$current_dir_path." created"); die();
            }

            $fsObject->touch($file_path);
            $fsObject->chmod($file_path, 0777);
            //headers line for CSV file
            $headers = "<? header(\"Content-Type: application/vnd.ms-word\");
                    header(\"Expires: 0\");
                    header(\"Cache-Control: must-revalidate, post-check=0, pre-check=0\");
                    header(\"content-disposition: attachment;filename=list.doc\");
                  ?>";
            $fsObject->appendToFile($file_path, $headers.$print);

            //values lines to put in CSV file
            echo (' DOCX File have been created: '. $file_path.PHP_EOL); die();
        } catch (IOExceptionInterface $exception) {
            echo "Error writing to file at". $exception->getPath(); die();
        }die();
    }



    /**
     * Print blank - template.
     * @IsGranted("ROLE_ADMIN")
     * @Method("GET")
     * may be usefull in a future. html not allowed! Для печати заполненных бланков/форм можно применить.
     */
    public function printForma(Event $event)
    {
        //$entityManager = $this->getDoctrine()->getManager();
       // $repository = $entityManager->getRepository(UserEvent::class);
       /// $userall = $repository->loadUsersByEvent($event->getId());
        $print = 'html код для записи в файл';

        $docx = new ZipArchive();
        $current_dir_path = getcwd();
        $file_path = $current_dir_path . "\uploads\blanks\blank.docx";

        if ($docx->open($file_path) === true) {
            $xml = $docx->getFromName('word/document.xml');

            $xml = str_replace('eventtitle', $event->getTitle(), $xml);
            $xml = str_replace('somepole', 'sometext', $xml);

            $docx->addFromString('word/document.xml', $xml);

            $docx->close();

        }
        else {var_dump('error '.$file_path); die();}

        return $this->redirectToRoute('event_show', ['id' => $event->getId(), 'success' => 'yess!']);
    }


}