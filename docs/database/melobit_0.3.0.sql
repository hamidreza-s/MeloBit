-- MySQL dump 10.13  Distrib 5.5.25a, for Linux (i686)
--
-- Host: localhost    Database: melobit
-- ------------------------------------------------------
-- Server version	5.5.25a

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `bugs`
--

DROP TABLE IF EXISTS `bugs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bugs` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `author` varchar(250) DEFAULT NULL,
  `email` varchar(250) DEFAULT NULL,
  `date` int(11) DEFAULT NULL,
  `url` varchar(250) DEFAULT NULL,
  `description` text,
  `priority` varchar(50) DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bugs`
--

LOCK TABLES `bugs` WRITE;
/*!40000 ALTER TABLE `bugs` DISABLE KEYS */;
/*!40000 ALTER TABLE `bugs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `menu_items`
--

DROP TABLE IF EXISTS `menu_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `menu_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `menu_id` int(11) DEFAULT NULL,
  `label` varchar(250) DEFAULT NULL,
  `page_id` int(11) DEFAULT NULL,
  `link` varchar(250) DEFAULT NULL,
  `position` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `menu_items`
--

LOCK TABLES `menu_items` WRITE;
/*!40000 ALTER TABLE `menu_items` DISABLE KEYS */;
INSERT INTO `menu_items` VALUES (1,1,'Manage Pages',0,'/page/list',1),(2,1,'Manage Manus',0,'/menu',2),(3,1,'Manage Users',0,'/user/list',3),(4,1,'Manage Bugs',0,'/bug/list',4),(5,1,'Build Search Index',0,'/search/build',5),(6,1,'Site Configuration',0,'/admin/config',6),(7,2,'MVC Architecture',1,NULL,1),(8,2,'EAV Data Model',2,NULL,2),(9,2,'Responsive Design',3,NULL,3),(10,2,'GPL License',4,NULL,4),(11,3,'How to install MeloBit',5,NULL,1),(12,3,'How to create skins',6,NULL,2),(13,3,'How to create modules',7,NULL,3);
/*!40000 ALTER TABLE `menu_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `menus`
--

DROP TABLE IF EXISTS `menus`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `menus` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `page_id` int(11) DEFAULT NULL,
  `link` varchar(250) DEFAULT NULL,
  `position` int(11) DEFAULT NULL,
  `access_level` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `menus`
--

LOCK TABLES `menus` WRITE;
/*!40000 ALTER TABLE `menus` DISABLE KEYS */;
INSERT INTO `menus` VALUES (1,'Admin',0,'/admin',1,'private'),(2,'Features',0,'/',6,'public'),(3,'Docs',0,'/',5,'public'),(4,'Download',0,'/',4,'public'),(5,'Contact',0,'/contact',3,'public'),(6,'About',8,NULL,2,'public');
/*!40000 ALTER TABLE `menus` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nodes`
--

DROP TABLE IF EXISTS `nodes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nodes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `page_id` int(11) DEFAULT NULL,
  `node` varchar(50) DEFAULT NULL,
  `content` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nodes`
--

LOCK TABLES `nodes` WRITE;
/*!40000 ALTER TABLE `nodes` DISABLE KEYS */;
INSERT INTO `nodes` VALUES (1,1,'headline','MeloBit MVC Architecture'),(2,1,'image','/images/upload/1351246214_mvc.png'),(3,1,'description','<p><strong>Model&ndash;View&ndash;Controller</strong> (MVC) is an architecture that separates the representation of information from the user\'s interaction with it.<sup id=\"cite_ref-0\" class=\"reference\"></sup><sup id=\"cite_ref-burbeck_1-0\" class=\"reference\"></sup>The <em>model</em> consists of application data and business rules, and the <em>controller</em> mediates input, converting it to commands for the model or view. <sup id=\"cite_ref-2\" class=\"reference\"></sup>A <em>view</em> can be any output representation of data, such as a chart or a diagram. Multiple views of the same data are possible, such as a pie chart for management and a tabular view for accountants. The central idea behind MVC is <a title=\"Code reuse\" href=\"http://en.wikipedia.org/wiki/Code_reuse\">code reusability</a> and <a title=\"Separation of concerns\" href=\"http://en.wikipedia.org/wiki/Separation_of_concerns\">separation of concerns</a>.<sup id=\"cite_ref-3\" class=\"reference\"></sup></p>'),(4,1,'content','<p>MeloBit uses this architecture in mind base on <a href=\"http://www.Zend.com\">Zend</a> Framework which is an open source, object oriented web application framework for <acronym class=\"acronym\">PHP</acronym> 5. Zend Framework is often called a \'component library\', because it has many loosely coupled components that you can use more or less independently. But Zend Framework also provides an advanced Model-View-Controller (<acronym class=\"acronym\">MVC</acronym>) implementation that can be used to establish a basic structure for your Zend Framework applications. A full list of Zend Framework components along with short descriptions may be found in the <a class=\"link external\" href=\"http://framework.zend.com/about/components\">&raquo; components overview</a>. In following you will be familar with these three parts:</p>\r\n<p class=\"para\"><strong><em class=\"emphasis\">Model</em></strong> - This is the part of your application that defines its basic functionality behind a set of abstractions. Data access routines and some business logic can be defined in the model.</p>\r\n<p class=\"para\"><strong><em class=\"emphasis\">View</em></strong> - Views define exactly what is presented to the user. Usually controllers pass data to each view to render in some format. Views will often collect data from the user, as well. This is where you\'re likely to find <acronym class=\"acronym\">HTML</acronym> markup in your <acronym class=\"acronym\">MVC</acronym> applications.</p>\r\n<p class=\"para\"><strong><em class=\"emphasis\">Controller</em></strong> - Controllers bind the whole pattern together. They manipulate models, decide which view to display based on the user\'s request and other factors, pass along the data that each view will need, or hand off control to another controller entirely. Most <acronym class=\"acronym\">MVC</acronym> experts recommend <a class=\"link external\" href=\"http://weblog.jamisbuck.org/2006/10/18/skinny-controller-fat-model\">&raquo; keeping controllers as skinny as possible</a>.</p>'),(5,2,'headline','MeloBit EAV Data Model'),(6,2,'image','/images/upload/1351246999_eav.png'),(7,2,'description','<p><strong>Entity&ndash;attribute&ndash;value model</strong> (<strong>EAV</strong>) is a <a title=\"Data model\" href=\"http://en.wikipedia.org/wiki/Data_model\">data model</a> to describe entities where the number of attributes (properties, parameters) that can be used to describe them is potentially vast, but the number that will actually apply to a given entity is relatively modest. In mathematics, this model is known as a <a title=\"Sparse matrix\" href=\"http://en.wikipedia.org/wiki/Sparse_matrix\">sparse matrix</a>. EAV is also known as <strong>object&ndash;attribute&ndash;value model</strong>, <strong>vertical database model</strong> and <strong>open schema</strong>.</p>'),(8,2,'content','<p>This data representation is analogous to space-efficient methods of storing a <a title=\"Sparse matrix\" href=\"http://en.wikipedia.org/wiki/Sparse_matrix\">sparse matrix</a>, where only non-empty values are stored. In an EAV data model, each attribute-value pair is a fact describing an entity, and a row in an EAV table stores a single fact. EAV tables are often described as \"long and skinny\": \"long\" refers to the number of rows, \"skinny\" to the few columns.</p>\r\n<p><strong>Data is recorded as three columns:</strong></p>\r\n<p><strong>The <em>entity</em>:</strong> the item being described. <strong>The <em>attribute</em> or <em>parameter</em>:</strong> a <a title=\"Foreign key\" href=\"http://en.wikipedia.org/wiki/Foreign_key\">foreign key</a> into a table of attribute definitions. At the very least, the attribute definitions table would contain the following columns: an attribute ID, attribute name, description, <a title=\"Data type\" href=\"http://en.wikipedia.org/wiki/Data_type\">data type</a>, and columns assisting input validation, e.g., maximum string length and regular expression, set of permissible values, etc. <strong>The <em>value</em></strong> of the attribute.</p>\r\n<p>MeloBit uses this data model in mind, so it does not need to create new database table for your new demands, just extend <strong>Melobit_Content_Item_Abstract</strong> class to have new data structure.</p>'),(9,3,'headline','MeloBit Responsive Web Design'),(10,3,'image','/images/upload/1351250784_rwd.jpg'),(11,3,'description','<p><strong>Responsive web design</strong> (often abbreviated to <strong>RWD</strong>) is an approach to web design in which a site is crafted to provide an optimal viewing experience&mdash;easy reading and navigation with a minimum of resizing, panning, and scrolling&mdash;across a wide range of devices (from desktop computer monitors to mobile phones).</p>'),(12,3,'content','<p>MeloBit implements Responsive Web Design based on <a href=\"http://foundation.zurb.com\">Foundation</a> Framework. So with MeloBit it doesn\'t matter that you are using your tablet, PC or mobile. <br />A site designed with RWD uses <a title=\"Cascading Style Sheets\" href=\"http://en.wikipedia.org/wiki/Cascading_Style_Sheets#CSS_3\">CSS3</a> <a title=\"Media queries\" href=\"http://en.wikipedia.org/wiki/Media_queries\">media queries</a>, an extension of the @media <code></code>rule, to adapt the layout to the viewing environment&mdash;along with fluid proportion-based grids and flexible images:<br /><a title=\"Media queries\" href=\"http://en.wikipedia.org/wiki/Media_queries\">Media queries</a> allow the page to use different CSS style rules based on characteristics of the device the site is being displayed on, most commonly the width of the <a title=\"Web browser\" href=\"http://en.wikipedia.org/wiki/Web_browser\">browser</a>. The fluid grid concept calls for page element sizing to be in relative units like percentages or <a title=\"Em (typography)\" href=\"http://en.wikipedia.org/wiki/Em_%28typography%29\">EMs</a>, rather than absolute units like <a title=\"Pixel\" href=\"http://en.wikipedia.org/wiki/Pixel\">pixels</a> or <a title=\"Point (typography)\" href=\"http://en.wikipedia.org/wiki/Point_%28typography%29\">points</a>. Flexible images are also sized in relative units (up to 100%), so as to prevent them from displaying outside their containing <a title=\"HTML element\" href=\"http://en.wikipedia.org/wiki/HTML_element\">element</a>.</p>'),(13,4,'headline','MeloBit GPL Version 2 License'),(14,4,'image','/images/upload/1351251811_gpl.png'),(15,4,'description','<p>The license under which the MeloBit software is released is the GPLv2 (or later) from the <a href=\"http://www.fsf.org/\">Free Software Foundation</a></p>'),(16,4,'content','<p>Copyright (C) 1989, 1991 Free Software Foundation, Inc.<br /> 51 Franklin St, Fifth Floor, Boston, MA 02110, USA</p>\r\n<p>Everyone is permitted to copy and distribute verbatim copies of this license document, but changing it is not allowed.</p>\r\n<h3>Preamble</h3>\r\n<p>The licenses for most software are designed to take away your freedom to share and change it. By contrast, the GNU General Public License is intended to guarantee your freedom to share and change free software &mdash; to make sure the software is free for all its users. This General Public License applies to most of the Free Software Foundation&rsquo;s software and to any other program whose authors commit to using it. (Some other Free Software Foundation software is covered by the GNU Library General Public License instead.) You can apply it to your programs, too.</p>\r\n<p>When we speak of free software, we are referring to freedom, not price. Our General Public Licenses are designed to make sure that you have the freedom to distribute copies of free software (and charge for this service if you wish), that you receive source code or can get it if you want it, that you can change the software or use pieces of it in new free programs; and that you know you can do these things.</p>\r\n<p>To protect your rights, we need to make restrictions that forbid anyone to deny you these rights or to ask you to surrender the rights. These restrictions translate to certain responsibilities for you if you distribute copies of the software, or if you modify it.</p>\r\n<p>For example, if you distribute copies of such a program, whether gratis or for a fee, you must give the recipients all the rights that you have. You must make sure that they, too, receive or can get the source code. And you must show them these terms so they know their rights.</p>\r\n<p>We protect your rights with two steps: (1) copyright the software, and (2) offer you this license which gives you legal permission to copy, distribute and/or modify the software.</p>\r\n<p>Also, for each author&rsquo;s protection and ours, we want to make certain that everyone understands that there is no warranty for this free software. If the software is modified by someone else and passed on, we want its recipients to know that what they have is not the original, so that any problems introduced by others will not reflect on the original authors\' reputations.</p>\r\n<p>Finally, any free program is threatened constantly by software patents. We wish to avoid the danger that redistributors of a free program will individually obtain patent licenses, in effect making the program proprietary. To prevent this, we have made it clear that any patent must be licensed for everyone&rsquo;s free use or not licensed at all.</p>\r\n<p>The precise terms and conditions for copying, distribution and modification follow.</p>\r\n<h3>GNU General Public License Terms and Conditions for Copying, Distribution, and Modification</h3>\r\n<ol start=\"0\">\r\n<li>This License applies to any program or other work which contains a notice placed by the copyright holder saying it may be distributed under the terms of this General Public License. The \"Program\", below, refers to any such program or work, and a \"work based on the Program\" means either the Program or any derivative work under copyright law: that is to say, a work containing the Program or a portion of it, either verbatim or with modifications and/or translated into another language. (Hereinafter, translation is included without limitation in the term \"modification\".) Each licensee is addressed as \"you\". Activities other than copying, distribution and modification are not covered by this License; they are outside its scope. The act of running the Program is not restricted, and the output from the Program is covered only if its contents constitute a work based on the Program (independent of having been made by running the Program). Whether that is true depends on what the Program does.</li>\r\n<li>You may copy and distribute verbatim copies of the Program&rsquo;s source code as you receive it, in any medium, provided that you conspicuously and appropriately publish on each copy an appropriate copyright notice and disclaimer of warranty; keep intact all the notices that refer to this License and to the absence of any warranty; and give any other recipients of the Program a copy of this License along with the Program. You may charge a fee for the physical act of transferring a copy, and you may at your option offer warranty protection in exchange for a fee.</li>\r\n<li>You may modify your copy or copies of the Program or any portion of it, thus forming a work based on the Program, and copy and distribute such modifications or work under the terms of Section 1 above, provided that you also meet all of these conditions:<ol type=\"a\">\r\n<li>You must cause the modified files to carry prominent notices stating that you changed the files and the date of any change.</li>\r\n<li>You must cause any work that you distribute or publish, that in whole or in part contains or is derived from the Program or any part thereof, to be licensed as a whole at no charge to all third parties under the terms of this License.</li>\r\n<li>If the modified program normally reads commands interactively when run, you must cause it, when started running for such interactive use in the most ordinary way, to print or display an announcement including an appropriate copyright notice and a notice that there is no warranty (or else, saying that you provide a warranty) and that users may redistribute the program under these conditions, and telling the user how to view a copy of this License. (Exception: if the Program itself is interactive but does not normally print such an announcement, your work based on the Program is not required to print an announcement.)</li>\r\n</ol>These requirements apply to the modified work as a whole. If identifiable sections of that work are not derived from the Program, and can be reasonably considered independent and separate works in themselves, then this License, and its terms, do not apply to those sections when you distribute them as separate works. But when you distribute the same sections as part of a whole which is a work based on the Program, the distribution of the whole must be on the terms of this License, whose permissions for other licensees extend to the entire whole, and thus to each and every part regardless of who wrote it. Thus, it is not the intent of this section to claim rights or contest your rights to work written entirely by you; rather, the intent is to exercise the right to control the distribution of derivative or collective works based on the Program. In addition, mere aggregation of another work not based on the Program with the Program (or with a work based on the Program) on a volume of a storage or distribution medium does not bring the other work under the scope of this License.</li>\r\n<li>You may copy and distribute the Program (or a work based on it, under Section 2) in object code or executable form under the terms of Sections 1 and 2 above provided that you also do one of the following:<ol type=\"a\">\r\n<li>Accompany it with the complete corresponding machine-readable source code, which must be distributed under the terms of Sections 1 and 2 above on a medium customarily used for software interchange; or,</li>\r\n<li>Accompany it with a written offer, valid for at least three years, to give any third party, for a charge no more than your cost of physically performing source distribution, a complete machine-readable copy of the corresponding source code, to be distributed under the terms of Sections 1 and 2 above on a medium customarily used for software interchange; or,</li>\r\n<li>Accompany it with the information you received as to the offer to distribute corresponding source code. (This alternative is allowed only for noncommercial distribution and only if you received the program in object code or executable form with such an offer, in accord with Subsection b above.) The source code for a work means the preferred form of the work for making modifications to it. For an executable work, complete source code means all the source code for all modules it contains, plus any associated interface definition files, plus the scripts used to control compilation and installation of the executable. However, as a special exception, the source code distributed need not include anything that is normally distributed (in either source or binary form) with the major components (compiler, kernel, and so on) of the operating system on which the executable runs, unless that component itself accompanies the executable. If distribution of executable or object code is made by offering access to copy from a designated place, then offering equivalent access to copy the source code from the same place counts as distribution of the source code, even though third parties are not compelled to copy the source along with the object code.</li>\r\n</ol></li>\r\n<li>You may not copy, modify, sublicense, or distribute the Program except as expressly provided under this License. Any attempt otherwise to copy, modify, sublicense or distribute the Program is void, and will automatically terminate your rights under this License. However, parties who have received copies, or rights, from you under this License will not have their licenses terminated so long as such parties remain in full compliance.</li>\r\n<li>You are not required to accept this License, since you have not signed it. However, nothing else grants you permission to modify or distribute the Program or its derivative works. These actions are prohibited by law if you do not accept this License. Therefore, by modifying or distributing the Program (or any work based on the Program), you indicate your acceptance of this License to do so, and all its terms and conditions for copying, distributing or modifying the Program or works based on it.</li>\r\n<li>Each time you redistribute the Program (or any work based on the Program), the recipient automatically receives a license from the original licensor to copy, distribute or modify the Program subject to these terms and conditions. You may not impose any further restrictions on the recipients\' exercise of the rights granted herein. You are not responsible for enforcing compliance by third parties to this License.</li>\r\n<li>If, as a consequence of a court judgment or allegation of patent infringement or for any other reason (not limited to patent issues), conditions are imposed on you (whether by court order, agreement or otherwise) that contradict the conditions of this License, they do not excuse you from the conditions of this License. If you cannot distribute so as to satisfy simultaneously your obligations under this License and any other pertinent obligations, then as a consequence you may not distribute the Program at all. For example, if a patent license would not permit royalty-free redistribution of the Program by all those who receive copies directly or indirectly through you, then the only way you could satisfy both it and this License would be to refrain entirely from distribution of the Program. If any portion of this section is held invalid or unenforceable under any particular circumstance, the balance of the section is intended to apply and the section as a whole is intended to apply in other circumstances. It is not the purpose of this section to induce you to infringe any patents or other property right claims or to contest validity of any such claims; this section has the sole purpose of protecting the integrity of the free software distribution system, which is implemented by public license practices. Many people have made generous contributions to the wide range of software distributed through that system in reliance on consistent application of that system; it is up to the author/donor to decide if he or she is willing to distribute software through any other system and a licensee cannot impose that choice. This section is intended to make thoroughly clear what is believed to be a consequence of the rest of this License.</li>\r\n<li>If the distribution and/or use of the Program is restricted in certain countries either by patents or by copyrighted interfaces, the original copyright holder who places the Program under this License may add an explicit geographical distribution limitation excluding those countries, so that distribution is permitted only in or among countries not thus excluded. In such case, this License incorporates the limitation as if written in the body of this License.</li>\r\n<li>The Free Software Foundation may publish revised and/or new versions of the General Public License from time to time. Such new versions will be similar in spirit to the present version, but may differ in detail to address new problems or concerns. Each version is given a distinguishing version number. If the Program specifies a version number of this License which applies to it and \"any later version\", you have the option of following the terms and conditions either of that version or of any later version published by the Free Software Foundation. If the Program does not specify a version number of this License, you may choose any version ever published by the Free Software Foundation.</li>\r\n<li>If you wish to incorporate parts of the Program into other free programs whose distribution conditions are different, write to the author to ask for permission. For software which is copyrighted by the Free Software Foundation, write to the Free Software Foundation; we sometimes make exceptions for this. Our decision will be guided by the two goals of preserving the free status of all derivatives of our free software and of promoting the sharing and reuse of software generally.</li>\r\n<li>BECAUSE THE PROGRAM IS LICENSED FREE OF CHARGE, THERE IS NO WARRANTY FOR THE PROGRAM, TO THE EXTENT PERMITTED BY APPLICABLE LAW. EXCEPT WHEN OTHERWISE STATED IN WRITING THE COPYRIGHT HOLDERS AND/OR OTHER PARTIES PROVIDE THE PROGRAM \"AS IS\" WITHOUT WARRANTY OF ANY KIND, EITHER EXPRESSED OR IMPLIED, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE. THE ENTIRE RISK AS TO THE QUALITY AND PERFORMANCE OF THE PROGRAM IS WITH YOU. SHOULD THE PROGRAM PROVE DEFECTIVE, YOU ASSUME THE COST OF ALL NECESSARY SERVICING, REPAIR OR CORRECTION.</li>\r\n<li>IN NO EVENT UNLESS REQUIRED BY APPLICABLE LAW OR AGREED TO IN WRITING WILL ANY COPYRIGHT HOLDER, OR ANY OTHER PARTY WHO MAY MODIFY AND/OR REDISTRIBUTE THE PROGRAM AS PERMITTED ABOVE, BE LIABLE TO YOU FOR DAMAGES, INCLUDING ANY GENERAL, SPECIAL, INCIDENTAL OR CONSEQUENTIAL DAMAGES ARISING OUT OF THE USE OR INABILITY TO USE THE PROGRAM (INCLUDING BUT NOT LIMITED TO LOSS OF DATA OR DATA BEING RENDERED INACCURATE OR LOSSES SUSTAINED BY YOU OR THIRD PARTIES OR A FAILURE OF THE PROGRAM TO OPERATE WITH ANY OTHER PROGRAMS), EVEN IF SUCH HOLDER OR OTHER PARTY HAS BEEN ADVISED OF THE POSSIBILITY OF SUCH DAMAGES.</li>\r\n</ol>'),(17,5,'headline','How to install MeloBit'),(18,5,'image',NULL),(19,5,'description','<p>In this article we teach you how to install MeloBit in your Local or Web Server. The level of this article is simple, because MeloBit has an installer which ease the installing process.</p>'),(20,5,'content','<p><strong>Requirements:</strong></p>\r\n<ol>\r\n<li>Apache web server.</li>\r\n<li>PHP version 5 or higer.</li>\r\n<li>20 MB host server.</li>\r\n<li>A created MySQL, SQLite, or ... database.</li>\r\n</ol>\r\n<p><strong>Instruction:</strong></p>\r\n<ol>\r\n<li>Download MeloBit from GitHub.</li>\r\n<li>Extract it in your server.</li>\r\n<li>Go to www.yoursite.com/installer path.</li>\r\n<li>Follow its three steps to create database and tables.</li>\r\n<li>Just this; Have Fun!</li>\r\n</ol>'),(21,6,'headline','How to create skins for MeloBit'),(22,6,'image',NULL),(23,6,'description','<p>In this article we teach you how to create skin (template) for MeloBit.</p>'),(24,6,'content','<p>In default package of MeloBit you can find two skins, <strong>blue</strong> which is a simple skin and <strong>foundation</strong> which is a both simple and responsive skin based on <a href=\"http://foundation.zurb.com\">Foundation</a> Framework. Because of the simplicity of these two skins, they can be a place to start crafting your own skin. They are stored in /public/skin path.</p>\r\n<p>In this article we learn you how to create skin based on foundation skin, because it is more capable and extendable.</p>\r\n<p>Now let\'s review default folders and files of foundation:</p>\r\n<p><strong>Folders:</strong></p>\r\n<ol>\r\n<li>icons</li>\r\n<li>images</li>\r\n<li>javascripts</li>\r\n<li>patterns</li>\r\n<li>stylesheets</li>\r\n<li>tinymce</li>\r\n</ol>\r\n<p><strong>Files:</strong></p>\r\n<ol>\r\n<li>footer.phtml</li>\r\n<li>header.phtml</li>\r\n<li>index.phtml</li>\r\n<li>nav.phtml</li>\r\n<li>page.phtml</li>\r\n</ol>\r\n<p>Because MeloBit uses MVC pattern, to Views is separated from Models and Controllers, so in these files you will not see programming language code, but just HTML, CSS and JavaScripts which are clear for Web designers. Therefor with changing them you can craft your own skins and have fun.</p>'),(25,7,'headline','How to create modules for MeloBit'),(26,7,'image',NULL),(27,7,'description','<p>In this article we teach you how to create modules (plug-in) for MeloBit. Modules are independent parts of MeloBit by which you can add your own functionality to your web site.</p>'),(28,7,'content','<p>The MeloBit development team anticipated that programmers would need to build modular applications, creating the conventional modular directory structure. This structure enables you to create modules, which are essentially separate MVC applications, that you can use with different front controllers. In this article, you&rsquo;ll learn about working with them by creating a module:</p>\r\n<ol>\r\n<li>Create a folder in /application/modules with an optional name (for example <em>HelloWorld</em>).</li>\r\n<li>Create three folders in&nbsp;<em>HelloWorld</em> modules folder: <em>models, views, controllers</em>.</li>\r\n<li>In <em>controllers</em> folder create a php file to create a class named<em>&nbsp;</em><em>HelloWorld_SayHello</em> to extend&nbsp;<em>Zend_Controller_Action. </em>Notice that you can have a lot of controllers for one modules and each controller has to have a name. In this case&nbsp;<em>SayHello</em> is the name of the controller.</li>\r\n<li>Each controller can have a lot of <em>actions</em>. To create an <em>action</em> you have to append <em>public function&nbsp;</em>to your controller class. The convention to name&nbsp;<em>actions</em> is&nbsp;<em>nameAction</em>. For Example&nbsp;<em>indexAction</em>, <em>listAction</em>, <em>createAction</em>, <em>editAction</em>, <em>deleteAction</em> and etc.</li>\r\n<li>In each <em>action </em>as its name denotes, you can create an action to do something like listing, creating, editing or deleting a page, a user or ... .</li>\r\n<li>Declare a function with <em>SayAction</em> name and in it declare a <em>property&nbsp;</em>for your current object and asign it to a string. For example <em>$this-&gt;view-&gt;name = \"World\".</em></li>\r\n<li>It is time to create a <em>view </em>script to render what <em>controller</em> did. Go to /application/modules/HelloWorld/views/scripts folder an create a folder with <em>say</em> name corresponds to your controller name. In this folder you have to create a file with <em>phtml</em> extension for each&nbsp;<em>action.</em></li>\r\n<li>Based on you <em>action</em> name, create <em>say.phtml</em> file, and fill it with&nbsp;<em>&lt;p&gt;Hello, &lt;?php echo $this-&gt;name; ?&gt;&lt;/p&gt;</em>.</li>\r\n<li>Now open your favorite web browser and navigate it to <em>www.yoursite.com/HelloWorld/say-hello/say. Have fun!<br /></em></li>\r\n</ol>'),(29,8,'headline','About MeloBit Team'),(30,8,'image',NULL),(31,8,'description','<p>We are few, but let\'s mention the name of great Web Developers like Forrest Lyman, Jason Gilmore, Jason Lengstorf and some other Apress, Oreilly, McGrawHill and Manning publication authors, who taught us how to code; to have a better world.<br /><br /><br /></p>'),(32,8,'content','<div class=\"row\">\r\n<div class=\"twelve columns\">\r\n<p><a class=\"th\"><img style=\"float: left; margin-right: 20px;\" src=\"/images/misc/hamidreza.jpg\" alt=\"Hamidreza Soleimani\" width=\"183\" height=\"283\" /></a> <strong>Hamidreza Soleimani <br /></strong><em>Founder, Developer and Designer of MeloBit</em></p>\r\n<p><br />His day work is in Engineering Center of Irankhodro Company and in nights; he is a passionate open source developer who fell in love with PHP. So he splits most of his free time between developing dynamic web sites powered by Zend Framework and designing them to look clean and impressive. When he is not in front of a computer, he is usually spending time with his wife (Nazanin) and his parents, or palying Setar which is a magical traditional Iraninan music instrument.</p>\r\n<p>&nbsp;</p>\r\n</div>\r\n</div>\r\n<div class=\"row\">\r\n<div class=\"twelve columns\">\r\n<p style=\"text-align: right;\"><a class=\"th\"><img style=\"float: right; margin-left: 20px;\" src=\"/images/misc/serge.jpg\" alt=\"Serge Keller\" /></a> <strong>Bernard Keller <br /></strong><em>Database Specialist and Project Manager of MeloBit</em></p>\r\n<p><br />He was introduced to a second-hand Apple IIGS computer, when he was 10 years old. This fueled his appetite for computer science which carried him through many different languages and databases. Serge settled on PHP as his language and MySQL at the end. From then on, he continued to pepper in various other web languages such as HTML, CSS and JavaScript while continually building on his PHP expertise. Along his career path, Bernad has designed and maintained plug-ins and modules for popular Content Management Systems, created web based content management tools for Internet users.</p>\r\n<p>&nbsp;</p>\r\n</div>\r\n</div>\r\n<p class=\"text-center\"><a class=\"button radious medium\" href=\"/contact\">Hire Us!</a></p>'),(33,9,'headline','Setting file permission'),(34,9,'image','/images/upload/1351653476_serge_1.jpg'),(35,9,'description','<p>test</p>'),(36,9,'content','<p>test</p>');
/*!40000 ALTER TABLE `nodes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pages`
--

DROP TABLE IF EXISTS `pages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) DEFAULT NULL,
  `namespace` varchar(50) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `date_created` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pages`
--

LOCK TABLES `pages` WRITE;
/*!40000 ALTER TABLE `pages` DISABLE KEYS */;
INSERT INTO `pages` VALUES (1,0,'page','melobit-mvc-architecture',1351246214),(2,0,'page','melobit-eav-data-model',1351246999),(3,0,'page','melobit-responsive-web-design',1351250784),(4,0,'page','melobit-gpl-version-2-license',1351251737),(5,0,'page','how-to-install-melobit',1351253023),(6,0,'page','how-to-create-skins-for-melobit',1351253496),(7,0,'page','how-to-create-modules-for-melobit',1351253572),(8,0,'page','about-melobit-team',1351253776),(9,0,'page','setting-file-permission',1351653398);
/*!40000 ALTER TABLE `pages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(250) DEFAULT NULL,
  `first_name` varchar(250) DEFAULT NULL,
  `last_name` varchar(250) DEFAULT NULL,
  `role` varchar(25) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'admin','21232f297a57a5a743894a0e4a801fc3','admin','admin','administrator');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2012-10-31  8:11:08
