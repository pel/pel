<?php
/**
 * package.xml generation script
 *
 * To create a package you need to do the following. Before making the package
 * PEL should be compiled so the .mo files are created.
 *
 * <code>
 * $ php makepackagexml.php make
 * $ pear package package.xml
 * </code>
 *
 * @package PEL
 * @author  Lars Olesen <lars@legestue.net>
 * @version @package-version@
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public
 */
require_once 'PEAR/PackageFileManager2.php';

$version = '0.9.2';
$stability = 'beta';
$notes = '* initial release as a PEAR package';
$url = 'http://downloads.sf.net/pel/PEL-' . $version . '.tgz';

PEAR::setErrorHandling(PEAR_ERROR_DIE);
$pfm = new PEAR_PackageFileManager2();
$pfm->setOptions(array(
    'baseinstalldir' => 'PEL',
    'filelistgenerator' => 'file',
    'packagedirectory' => dirname(__FILE__),
    'packagefile' => 'package.xml',
    'ignore' => array(
        'makepackagexml.php',
        '*.tgz',
        '*.sh',
        'test/',
        'tutorials/',
        'authors.xml'
    ),
    'dir_roles' => array(
        'doc' => 'doc',
        'examples' => 'doc',
        'test' => 'test'
    ),
    'exceptions' => array(
        'README' => 'doc',
        'AUTHORS' => 'doc',
        'COPYING' => 'doc',
        'INSTALL' => 'doc',
        'NEWS' => 'doc',
        'TODO' => 'doc'
    ),
    'simpleoutput' => true
));

$pfm->setPackage('PEL');
$pfm->setSummary('The PHP Exif Library (PEL) lets you fully manipulate Exif (Exchangeable Image File Format) data.');
$pfm->setDescription('The PHP Exif Library (PEL) lets you fully manipulate Exif (Exchangeable Image File Format) data. This is the data that digital cameras place in their images, such as the date and time, shutter speed, ISO value and so on.

Using PEL, one can fully modify the Exif data, meaning that it can be both read and written. Completely new Exif data can also be added to images. PEL is written completely in PHP and depends on nothing except a standard installation of PHP, version 5. PEL is hosted on SourceForge.');
$pfm->setUri($url);
$pfm->setLicense('GPL License', 'http://www.gnu.org/licenses/gpl.html');
$pfm->addMaintainer('lead', 'mgeisler', 'Martin Geisler', 'mgeisler@mgeisler.net');
$pfm->addMaintainer('helper', 'lsolesen', 'Lars Olesen', 'lars@legestue.net');

$pfm->setPackageType('php');

$pfm->setAPIVersion($version);
$pfm->setReleaseVersion($version);
$pfm->setAPIStability($stability);
$pfm->setReleaseStability($stability);
$pfm->setNotes($notes);
$pfm->addRelease();

$pfm->clearDeps();
$pfm->setPhpDep('5.0.0');
$pfm->setPearinstallerDep('1.5.0');

$pfm->generateContents();

if (isset($_GET['make']) || (isset($_SERVER['argv']) && $_SERVER['argv'][1] == 'make')) {
    if ($pfm->writePackageFile()) {
        exit('package created');
    }
} else {
    $pfm->debugPackageFile();
}
