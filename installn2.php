<?
/*
 * "n2" - Forum Software - a nBBS v0.6 + wtcBB remix.
 * Copyright (C) 2009 Chris F. Ravenscroft
 * 
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License as published by the Free Software
 * Foundation; either version 2 of the License, or (at your option) any later
 * version.
 * 
 * This program is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE. See the GNU General Public License for more
 * details.
 * 
 * You should have received a copy of the GNU General Public License along with
 * this program; if not, write to the Free Software Foundation, Inc., 59 Temple
 * Place, Suite 330, Boston, MA 02111-1307 USA
 * 
 * Questions? We can be reached at http://www.nextbbs.com
 */

/*
 * IMPORTANT NOTE: This class contains code lifted from Vincent Blavet's excellent
 * PclLib library.
 * This code is used to uncompress zip data without calling zip_xxx php functions as
 * these are not
 * always compiled in PHP.
 * However, this code still requires your PHP library to be linked against zlib.
 *
 * For more information on PclLib, which is GNU/LGPL, go to http://www.phpconcept.net
 *
 */
class Preinstall
{
	function Preinstall($filename, $redirect)
	{
		$this->header();
		if(isset($_GET['do']) && $_GET['do']=='install')
		{
			$ret = $this->extractData($filename);
			if($ret>0)
				$this->info('<div class="clean-ok"><a href="'.$redirect.'">Start Installation Wizard</div>');
			else
				exit;
		}
		else
			$this->welcome();
		$this->footer();
	}

        function throwError($e)
        {
                ?>
                <div align='center' style='color:red;font-weight:bold;'>
                <?=$e;?>
                </div>
                <?
                exit;
        }

	function header()
	{
		print <<<EOB
<html>
<head>		
  <style type="text/css">
.clean-info {
    border:solid 1px #DEDEDE;
    background:#FFFFCC;
    color:#222222;
    padding:4px;
    text-align:center;
}
.clean-background {
        border:solid 1px #DEDEDE;
        background:#EFEFEF;
        color:#222222;
        padding:4px;
        text-align:center;
}
.clean-ok {
        border:solid 1px #349534;
        background:#C9FFCA;
        color:#008000;
        font-weight:bold;
        padding:4px;
        text-align:center; 
}
.lefty {
    text-align:left;
}
  </style>
</head>
<body>
		
EOB;
	}
	
	function footer()
	{
		print "</body>\n</html>";
	}
	
	function info($msg, $bNoLF=false)
	{
		$lf = $bNoLF ? '' : '<br />';
		print $msg.$lf."\n";
		ob_flush();
		flush();
	}

	function welcome()
	{
		if(@touch("testfile"))
		{
			unlink("testfile");
			$xtra = <<<EOB
<div class='clean-ok'>			
&gt;&gt;&gt;&nbsp;<a href='?do=install'>Install</a>&nbsp;&lt;&lt;&lt;
</div>
EOB;
		}
		else
		{
			if(!@chmod('.', 0777))
			{
				$xtra = <<<EOB
Make the install directory world-writable for now: <span style='font-weight:bold;'>chmod 0777 .</span><br />then refresh this page to continue install.<br />
(I will re-protect this directory or ask you to do so)<br />
EOB;
			}
			else
			{
				$xtra = <<<EOB
<div class='clean-ok'>
&gt;&gt;&gt;&nbsp;<a href='?do=install'>Install</a>&nbsp;&lt;&lt;&lt;
</div>
EOB;
			}
		}
		
		$html = <<<EOB
<script type="text/javascript">
function toggleLayer(layerid)
{
	if(document.layers)
	{
		document.layers[layerid].visibility = (document.layers[layerid].visibility=='hide'?'show':'hide');
	}
	else
	{
		if(document.getElementById)
		{
			var obj = document.getElementById(layerid);
		}
		else if(document.all)
		{
			var obj = document.all[layerid];
		}
		else
		{
			return;
		}
		if(obj.style.display=='none')
		{
			obj.style.display = 'block';
		}
		else
		{
			obj.style.display = 'none';
		}
	}
}
</script>
<div class='clean-info'>
Welcome to <em>n2</em>'s pre-install util.
</div><br />
<div class='clean-background'>
<br />
If you are about to upgrade your message board,
<a href="javascript:toggleLayer('upgrade');">
read this warning
</a>
.<br /><br />
<div class='lefty' id='upgrade' style='display:none; position:relative;'>
<fieldset>
<legend>Upgrade Warning</legend>
<ul>
<li>When you click 'Install', your existing program files will be replaced with their updated revision.<br />
If you have made modifications to these files, they will be lost and will have to be merged -again- into the new files.<br />&nbsp;</li>
<li>Your configuration will not be lost.</li>
</ul>
If you need to make a backup now, do not click 'Install'; instead, perform a backup, then come back here!
</fieldset>
<br />
</div>
Please read these notes about
<a href="javascript:toggleLayer('uncompress');">
problems uncompressing files
</a>
.<br /><br />
<div class='lefty' id='uncompress' style='display:none; position:relative;'>
<fieldset>
<legend>About Files Problems</legend>
It is possible that, after clicking 'Install', the next page will display a red error code:<br /><br />
Most PHP programs come with a semi-automated install process: you have to copy all the program's files to your web server before running a configuration script - if any.<br /><br />
<em>n2</em> is very easy to install on 'friendly' web servers: just upload two files, run the installer and let it guide you through its configuration wizard.<br />
Unfortunately, there are about as many possible configurations as there are web servers; as a result, the installer may be unable to properly copy your new files.<br />
If this happens, you will need to follow the inistructions provided on the next page; these instructions allow you to revert to a 'traditional' setup process.
</fieldset>
<br />
</div>
</div>
<br />
{$xtra}
EOB;
		$this->info($html);
	}

	function extractData($filename)
	{
		$this->info("
<div class='clean-info'>		
Welcome to <em>n2</em>!
</div><br />
<div class='clean-background'>
<br />
<div class='lefty'>
I am now going to try and uncompress the data file.<br />
If I fail, and you see strange error messages being displayed, it is for one of two reasons:<br /><br />
1. Either you have not changed the access rights of the directory where I am running,<br />
&nbsp;&nbsp;&nbsp;allowing the web server to create new files.<br />
&nbsp;&nbsp;&nbsp;Make the install directory world-writable for now: <span style='font-weight:bold;'>chmod 0777 .</span><br /><br />
2. Or this server is running PhpSuExec (ask your host!) and it does not like self-extracting scripts.<br />
&nbsp;&nbsp;&nbsp;If this is the case, you are going to have to install nBBS the old standard way:<br />
&nbsp;&nbsp;&nbsp;2.1. On your personal computer, rename installn2.data to installn2.zip<br />
&nbsp;&nbsp;&nbsp;2.2. Uncompress installn2.zip<br />
&nbsp;&nbsp;&nbsp;2.3. Upload the newly extracted hierarchy of files to your web server<br />
&nbsp;&nbsp;&nbsp;2.4. Run install.php
</div><br />
");
		$this->info('Uncompressing data', true);
		$zip = new PclZip($filename);
		$ret = $zip->extract('./');
		if($ret>0)
		{
			$this->info('<span style="color:green;">[OK]</span>');
			if(!@chmod('.', 0555))
				$this->info("<br />\n\nProtect this directory! <span style='font-weight:bold;'>chmod 0555 .</span>");
			if(!@unlink('installn2.data'))
				$this->info("<br />\n\nRemove installn2.data! <span style='font-weight:bold;'>rm installn2.data</span>");
			if(!@unlink('installn2.php'))
				$this->info("<br />\n\nRemove installn2.php! <span style='font-weight:bold;'>rm installn2.php</span>");
			// Attempt to set correct privileges
			@chmod('attach',   0777);
			@chmod('cache',    0777);
			@chmod('css',      0777);
			@chmod('exports',  0777);
			@chmod('language', 0777);
			@chmod('images',   0777);
			@chmod('images/avatars',      0777);
			@chmod('images/icons',        0777);
			@chmod('images/ranks',        0777);
			@chmod('images/smilies',      0777);
			@chmod('includes/config.php', 0777);
		}
		$this->info("
<br />
</div>");
		return $ret;
	}
}

@chmod('.', 0777); // For suPHP
new Preinstall('installn2.data', 'install.php');
@chmod('.', 0555);

class PclZip
{
    var $zipname = '';

    var $zip_fd = 0;

    var $error_code = 1;
    var $error_string = '';
    
    var $magic_quotes_status;

  function PclZip($p_zipname)
  {
    if (!function_exists('gzopen'))
    {
      die('Abort '.basename(__FILE__).' : Missing zlib extensions');
    }

    $this->zipname = $p_zipname;
    $this->zip_fd = 0;
    $this->magic_quotes_status = -1;

  // ----- Constants
  define( 'PCLZIP_READ_BLOCK_SIZE', 2048 );
  
  define( 'PCLZIP_ERR_USER_ABORTED', 2 );
  define( 'PCLZIP_ERR_NO_ERROR', 0 );
  define( 'PCLZIP_ERR_WRITE_OPEN_FAIL', -1 );
  define( 'PCLZIP_ERR_READ_OPEN_FAIL', -2 );
  define( 'PCLZIP_ERR_INVALID_PARAMETER', -3 );
  define( 'PCLZIP_ERR_MISSING_FILE', -4 );
  define( 'PCLZIP_ERR_FILENAME_TOO_LONG', -5 );
  define( 'PCLZIP_ERR_INVALID_ZIP', -6 );
  define( 'PCLZIP_ERR_BAD_EXTRACTED_FILE', -7 );
  define( 'PCLZIP_ERR_DIR_CREATE_FAIL', -8 );
  define( 'PCLZIP_ERR_BAD_EXTENSION', -9 );
  define( 'PCLZIP_ERR_BAD_FORMAT', -10 );
  define( 'PCLZIP_ERR_DELETE_FILE_FAIL', -11 );
  define( 'PCLZIP_ERR_RENAME_FILE_FAIL', -12 );
  define( 'PCLZIP_ERR_BAD_CHECKSUM', -13 );
  define( 'PCLZIP_ERR_INVALID_ARCHIVE_ZIP', -14 );
  define( 'PCLZIP_ERR_MISSING_OPTION_VALUE', -15 );
  define( 'PCLZIP_ERR_INVALID_OPTION_VALUE', -16 );
  define( 'PCLZIP_ERR_ALREADY_A_DIRECTORY', -17 );
  define( 'PCLZIP_ERR_UNSUPPORTED_COMPRESSION', -18 );
  define( 'PCLZIP_ERR_UNSUPPORTED_ENCRYPTION', -19 );

  // ----- Options values
  define( 'PCLZIP_OPT_PATH', 77001 );
  define( 'PCLZIP_OPT_ADD_PATH', 77002 );
  define( 'PCLZIP_OPT_REMOVE_PATH', 77003 );
  define( 'PCLZIP_OPT_REMOVE_ALL_PATH', 77004 );
  define( 'PCLZIP_OPT_SET_CHMOD', 77005 );
  define( 'PCLZIP_OPT_EXTRACT_AS_STRING', 77006 );
  define( 'PCLZIP_OPT_NO_COMPRESSION', 77007 );
  define( 'PCLZIP_OPT_BY_NAME', 77008 );
  define( 'PCLZIP_OPT_BY_INDEX', 77009 );
  define( 'PCLZIP_OPT_BY_EREG', 77010 );
  define( 'PCLZIP_OPT_BY_PREG', 77011 );
  define( 'PCLZIP_OPT_COMMENT', 77012 );
  define( 'PCLZIP_OPT_ADD_COMMENT', 77013 );
  define( 'PCLZIP_OPT_PREPEND_COMMENT', 77014 );
  define( 'PCLZIP_OPT_EXTRACT_IN_OUTPUT', 77015 );
  define( 'PCLZIP_OPT_REPLACE_NEWER', 77016 );
  define( 'PCLZIP_OPT_STOP_ON_ERROR', 77017 );

    return;
  }

  function errorCode()
  {
    print "<font color='red'>[<strong>Error</strong>&nbsp;".$this->error_string."( ".$this->error_code." )]</font><br />\n";
    return($this->error_code);
  }

  function extract($v_path)
  {
    $v_result=1;

      $this->error_code = 0;
      $this->error_string = '';

    $v_options = array();

    $v_options[PCLZIP_OPT_EXTRACT_AS_STRING] = FALSE;
    $v_options[PCLZIP_OPT_STOP_ON_ERROR] = TRUE;
    $v_options[PCLZIP_OPT_SET_CHMOD] = 0755;

    $p_list = array();
    $v_result = $this->privExtractByRule($p_list, $v_path, $v_options);
    if ($v_result < 1) {
      unset($p_list);
      return(0);
    }

    return $p_list;
  }

  function privOpenFd($p_mode)
  {
    $v_result=1;

    if ($this->zip_fd != 0)
    {
      PclZip::privErrorLog(PCLZIP_ERR_READ_OPEN_FAIL, 'Zip file \''.$this->zipname.'\' already open');

      return PclZip::errorCode();
    }

    if (($this->zip_fd = @fopen($this->zipname, $p_mode)) == 0)
    {
      PclZip::privErrorLog(PCLZIP_ERR_READ_OPEN_FAIL, 'Unable to open archive \''.$this->zipname.'\' in '.$p_mode.' mode');

      return PclZip::errorCode();
    }

    return $v_result;
  }

  function privCloseFd()
  {
    $v_result=1;

    if ($this->zip_fd != 0)
      @fclose($this->zip_fd);
    $this->zip_fd = 0;

    return $v_result;
  }

  function privConvertHeader2FileInfo($p_header, &$p_info)
  {
    $v_result=1;

    $p_info['filename'] = $p_header['filename'];
    $p_info['stored_filename'] = $p_header['stored_filename'];
    $p_info['size'] = $p_header['size'];
    $p_info['compressed_size'] = $p_header['compressed_size'];
    $p_info['mtime'] = $p_header['mtime'];
    $p_info['comment'] = $p_header['comment'];
    $p_info['folder'] = (($p_header['external']&0x00000010)==0x00000010);
    $p_info['index'] = $p_header['index'];
    $p_info['status'] = $p_header['status'];

    return $v_result;
  }

  function privExtractByRule(&$p_file_list, $p_path, &$p_options)
  {
    $v_result=1;

    $this->privDisableMagicQuotes();

    if (($v_result = $this->privOpenFd('rb')) != 1)
    {
      $this->privSwapBackMagicQuotes();
      return $v_result;
    }

    $v_central_dir = array();
    if (($v_result = $this->privReadEndCentralDir($v_central_dir)) != 1)
    {
      $this->privCloseFd();
      $this->privSwapBackMagicQuotes();

      return $v_result;
    }

    $v_pos_entry = $v_central_dir['offset'];

    $j_start = 0;
    for ($i=0, $v_nb_extracted=0; $i<$v_central_dir['entries']; $i++)
    {
      @rewind($this->zip_fd);
      if (@fseek($this->zip_fd, $v_pos_entry))
      {
        $this->privCloseFd();
        $this->privSwapBackMagicQuotes();

        PclZip::privErrorLog(PCLZIP_ERR_INVALID_ARCHIVE_ZIP, 'Invalid archive size');

        return PclZip::errorCode();
      }

      $v_header = array();
      if (($v_result = $this->privReadCentralFileHeader($v_header)) != 1)
      {
        $this->privCloseFd();
        $this->privSwapBackMagicQuotes();

        return $v_result;
      }

      $v_header['index'] = $i;

      $v_pos_entry = ftell($this->zip_fd);

          $v_extract = true; // CFR: always the only search method here...

	  // ----- Check compression method
	  if (   ($v_extract)
	      && (   ($v_header['compression'] != 8)
		      && ($v_header['compression'] != 0))) {
          $v_header['status'] = 'unsupported_compression';

          if (   (isset($p_options[PCLZIP_OPT_STOP_ON_ERROR]))
		      && ($p_options[PCLZIP_OPT_STOP_ON_ERROR]===true)) {

              $this->privSwapBackMagicQuotes();
              
              PclZip::privErrorLog(PCLZIP_ERR_UNSUPPORTED_COMPRESSION,
			                       "Filename '".$v_header['stored_filename']."' is "
				  	    	  	   ."compressed by an unsupported compression "
				  	    	  	   ."method (".$v_header['compression'].") ");

              return PclZip::errorCode();
		  }
	  }
	  
	  // ----- Check encrypted files
	  if (($v_extract) && (($v_header['flag'] & 1) == 1)) {
          $v_header['status'] = 'unsupported_encryption';

          if (   (isset($p_options[PCLZIP_OPT_STOP_ON_ERROR]))
		      && ($p_options[PCLZIP_OPT_STOP_ON_ERROR]===true)) {

              $this->privSwapBackMagicQuotes();

              PclZip::privErrorLog(PCLZIP_ERR_UNSUPPORTED_ENCRYPTION,
			                       "Unsupported encryption for "
				  	    	  	   ." filename '".$v_header['stored_filename']
								   ."'");

              return PclZip::errorCode();
		  }
	  }

      if (($v_extract) && ($v_header['status'] != 'ok')) {
          $v_result = $this->privConvertHeader2FileInfo($v_header,
		                                        $p_file_list[$v_nb_extracted++]);
          if ($v_result != 1) {
              $this->privCloseFd();
              $this->privSwapBackMagicQuotes();
              return $v_result;
          }

          $v_extract = false;
      }
      
      if ($v_extract)
      {
        @rewind($this->zip_fd);
        if (@fseek($this->zip_fd, $v_header['offset']))
        {
          $this->privCloseFd();

          $this->privSwapBackMagicQuotes();

          PclZip::privErrorLog(PCLZIP_ERR_INVALID_ARCHIVE_ZIP, 'Invalid archive size');

          return PclZip::errorCode();
        }

        { // CFR: always extract to files
          $v_result1 = $this->privExtractFile($v_header, $p_path, $p_options);
          if ($v_result1 < 1) {
            $this->privCloseFd();
            $this->privSwapBackMagicQuotes();
            return $v_result1;
          }

          if (($v_result = $this->privConvertHeader2FileInfo($v_header, $p_file_list[$v_nb_extracted++])) != 1)
          {
            $this->privCloseFd();
            $this->privSwapBackMagicQuotes();

            return $v_result;
          }

          if ($v_result1 == 2) {
          	break;
          }
        }
      }
    }

    $this->privCloseFd();
    $this->privSwapBackMagicQuotes();

    return $v_result;
  }

  function privExtractFile(&$p_entry, $p_path, &$p_options)
  {
    $v_result=1;

    if (($v_result = $this->privReadFileHeader($v_header)) != 1)
    {
      return $v_result;
    }

    if ($p_path != '')
    {
      $p_entry['filename'] = $p_path."/".$p_entry['filename'];
    }

    if ($p_entry['status'] == 'ok') {

    if (file_exists($p_entry['filename']))
    {
      if (is_dir($p_entry['filename']))
      {
	// Well, cool, it must be an upgrade then...
	/*
        $p_entry['status'] = "already_a_directory";
        
        if (   (isset($p_options[PCLZIP_OPT_STOP_ON_ERROR]))
		    && ($p_options[PCLZIP_OPT_STOP_ON_ERROR]===true)) {
            PclZip::privErrorLog(PCLZIP_ERR_ALREADY_A_DIRECTORY,
			                     "Filename '".$p_entry['filename']."' is "
								 ."already used by an existing directory");
            return PclZip::errorCode();
		}
	*/
      }
      else if (!is_writeable($p_entry['filename']))
      {
        $p_entry['status'] = "write_protected";

        if (   (isset($p_options[PCLZIP_OPT_STOP_ON_ERROR]))
		    && ($p_options[PCLZIP_OPT_STOP_ON_ERROR]===true)) {

            PclZip::privErrorLog(PCLZIP_ERR_WRITE_OPEN_FAIL,
			                     "Filename '".$p_entry['filename']."' exists "
								 ."and is write protected");

            return PclZip::errorCode();
		}
      }
    }

    else {
      if ((($p_entry['external']&0x00000010)==0x00000010) || (substr($p_entry['filename'], -1) == '/'))
        $v_dir_to_check = $p_entry['filename'];
      else if (!strstr($p_entry['filename'], "/"))
        $v_dir_to_check = "";
      else
        $v_dir_to_check = dirname($p_entry['filename']);

      if (($v_result = $this->privDirCheck($v_dir_to_check, (($p_entry['external']&0x00000010)==0x00000010))) != 1) {

        $p_entry['status'] = "path_creation_fail";

        $v_result = 1;
      }
    }
    }

    // ----- Look if extraction should be done
    if ($p_entry['status'] == 'ok') {

      if (!(($p_entry['external']&0x00000010)==0x00000010))
      {
        if ($p_entry['compression'] == 0) {
          if (($v_dest_file = @fopen($p_entry['filename'], 'wb')) == 0)
          {
            $p_entry['status'] = "write_error";
            return $v_result;
          }

          $v_size = $p_entry['compressed_size'];
          while ($v_size != 0)
          {
            $v_read_size = ($v_size < PCLZIP_READ_BLOCK_SIZE ? $v_size : PCLZIP_READ_BLOCK_SIZE);
            $v_buffer = @fread($this->zip_fd, $v_read_size);
            @fwrite($v_dest_file, $v_buffer, $v_read_size);            
            $v_size -= $v_read_size;
          }

          fclose($v_dest_file);

          touch($p_entry['filename'], $p_entry['mtime']);
          

        }
        else {
          if (($p_entry['flag'] & 1) == 1) {
          }
          else {
              $v_buffer = @fread($this->zip_fd, $p_entry['compressed_size']);
          }
          
          $v_file_content = @gzinflate($v_buffer);
          unset($v_buffer);
          if ($v_file_content === FALSE) {
            $p_entry['status'] = "error";
            return $v_result;
          }
          
          if (($v_dest_file = @fopen($p_entry['filename'], 'wb')) == 0) {
            $p_entry['status'] = "write_error";
            return $v_result;
          }

          @fwrite($v_dest_file, $v_file_content, $p_entry['size']);
          unset($v_file_content);

          @fclose($v_dest_file);

          @touch($p_entry['filename'], $p_entry['mtime']);
        }

        if (isset($p_options[PCLZIP_OPT_SET_CHMOD])) {
          @chmod($p_entry['filename'], $p_options[PCLZIP_OPT_SET_CHMOD]);
        }
      }
    }
	if ($p_entry['status'] == "aborted") {
      $p_entry['status'] = "skipped";
	}
	
    return $v_result;
  }

  function privReadFileHeader(&$p_header)
  {
    $v_result=1;

    $v_binary_data = @fread($this->zip_fd, 4);
    $v_data = unpack('Vid', $v_binary_data);

    if ($v_data['id'] != 0x04034b50)
    {
      PclZip::privErrorLog(PCLZIP_ERR_BAD_FORMAT, 'Invalid archive structure');
      return PclZip::errorCode();
    }

    $v_binary_data = fread($this->zip_fd, 26);

    if (strlen($v_binary_data) != 26)
    {
      $p_header['filename'] = "";
      $p_header['status'] = "invalid_header";
      PclZip::privErrorLog(PCLZIP_ERR_BAD_FORMAT, "Invalid block size : ".strlen($v_binary_data));
      return PclZip::errorCode();
    }

    $v_data = unpack('vversion/vflag/vcompression/vmtime/vmdate/Vcrc/Vcompressed_size/Vsize/vfilename_len/vextra_len', $v_binary_data);

    $p_header['filename'] = fread($this->zip_fd, $v_data['filename_len']);
    if ($v_data['extra_len'] != 0) {
      $p_header['extra'] = fread($this->zip_fd, $v_data['extra_len']);
    }
    else {
      $p_header['extra'] = '';
    }
    $p_header['version_extracted'] = $v_data['version'];
    $p_header['compression'] = $v_data['compression'];
    $p_header['size'] = $v_data['size'];
    $p_header['compressed_size'] = $v_data['compressed_size'];
    $p_header['crc'] = $v_data['crc'];
    $p_header['flag'] = $v_data['flag'];
    $p_header['filename_len'] = $v_data['filename_len'];

    $p_header['mdate'] = $v_data['mdate'];
    $p_header['mtime'] = $v_data['mtime'];
    if ($p_header['mdate'] && $p_header['mtime'])
    {
      $v_hour = ($p_header['mtime'] & 0xF800) >> 11;
      $v_minute = ($p_header['mtime'] & 0x07E0) >> 5;
      $v_seconde = ($p_header['mtime'] & 0x001F)*2;

      $v_year = (($p_header['mdate'] & 0xFE00) >> 9) + 1980;
      $v_month = ($p_header['mdate'] & 0x01E0) >> 5;
      $v_day = $p_header['mdate'] & 0x001F;

      $p_header['mtime'] = mktime($v_hour, $v_minute, $v_seconde, $v_month, $v_day, $v_year);
    }
    else
    {
      $p_header['mtime'] = time();
    }

    $p_header['stored_filename'] = $p_header['filename'];

    $p_header['status'] = "ok";

    return $v_result;
  }

  function privReadCentralFileHeader(&$p_header)
  {
    $v_result=1;

    $v_binary_data = @fread($this->zip_fd, 4);
    $v_data = unpack('Vid', $v_binary_data);

    if ($v_data['id'] != 0x02014b50)
    {
      PclZip::privErrorLog(PCLZIP_ERR_BAD_FORMAT, 'Invalid archive structure');
      return PclZip::errorCode();
    }

    $v_binary_data = fread($this->zip_fd, 42);

    if (strlen($v_binary_data) != 42)
    {
      $p_header['filename'] = "";
      $p_header['status'] = "invalid_header";
      PclZip::privErrorLog(PCLZIP_ERR_BAD_FORMAT, "Invalid block size : ".strlen($v_binary_data));
      return PclZip::errorCode();
    }

    $p_header = unpack('vversion/vversion_extracted/vflag/vcompression/vmtime/vmdate/Vcrc/Vcompressed_size/Vsize/vfilename_len/vextra_len/vcomment_len/vdisk/vinternal/Vexternal/Voffset', $v_binary_data);

    if ($p_header['filename_len'] != 0)
      $p_header['filename'] = fread($this->zip_fd, $p_header['filename_len']);
    else
      $p_header['filename'] = '';
    if ($p_header['extra_len'] != 0)
      $p_header['extra'] = fread($this->zip_fd, $p_header['extra_len']);
    else
      $p_header['extra'] = '';
    if ($p_header['comment_len'] != 0)
      $p_header['comment'] = fread($this->zip_fd, $p_header['comment_len']);
    else
      $p_header['comment'] = '';

    if ($p_header['mdate'] && $p_header['mtime'])
    {
      $v_hour = ($p_header['mtime'] & 0xF800) >> 11;
      $v_minute = ($p_header['mtime'] & 0x07E0) >> 5;
      $v_seconde = ($p_header['mtime'] & 0x001F)*2;

      $v_year = (($p_header['mdate'] & 0xFE00) >> 9) + 1980;
      $v_month = ($p_header['mdate'] & 0x01E0) >> 5;
      $v_day = $p_header['mdate'] & 0x001F;

      $p_header['mtime'] = mktime($v_hour, $v_minute, $v_seconde, $v_month, $v_day, $v_year);
    }
    else
    {
      $p_header['mtime'] = time();
    }

    $p_header['stored_filename'] = $p_header['filename'];

    $p_header['status'] = 'ok';

    if (substr($p_header['filename'], -1) == '/') {
      $p_header['external'] = 0x00000010;
    }

    return $v_result;
  }

  function privReadEndCentralDir(&$p_central_dir)
  {
    $v_result=1;

    $v_size = filesize($this->zipname);
    @fseek($this->zip_fd, $v_size);
    if (@ftell($this->zip_fd) != $v_size)
    {
      PclZip::privErrorLog(PCLZIP_ERR_BAD_FORMAT, 'Unable to go to the end of the archive \''.$this->zipname.'\'');
      return PclZip::errorCode();
    }

    $v_found = 0;
    if ($v_size > 26) {
      @fseek($this->zip_fd, $v_size-22);
      if (($v_pos = @ftell($this->zip_fd)) != ($v_size-22))
      {
        PclZip::privErrorLog(PCLZIP_ERR_BAD_FORMAT, 'Unable to seek back to the middle of the archive \''.$this->zipname.'\'');
        return PclZip::errorCode();
      }

      $v_binary_data = @fread($this->zip_fd, 4);
      $v_data = @unpack('Vid', $v_binary_data);
      if ($v_data['id'] == 0x06054b50) {
        $v_found = 1;
      }

      $v_pos = ftell($this->zip_fd);
    }

    if (!$v_found) {
      $v_maximum_size = 65557; // 0xFFFF + 22;
      if ($v_maximum_size > $v_size)
        $v_maximum_size = $v_size;
      @fseek($this->zip_fd, $v_size-$v_maximum_size);
      if (@ftell($this->zip_fd) != ($v_size-$v_maximum_size))
      {
        PclZip::privErrorLog(PCLZIP_ERR_BAD_FORMAT, 'Unable to seek back to the middle of the archive \''.$this->zipname.'\'');
        return PclZip::errorCode();
      }
      $v_pos = ftell($this->zip_fd);
      $v_bytes = 0x00000000;
      while ($v_pos < $v_size)
      {
        $v_byte = @fread($this->zip_fd, 1);

        $v_bytes = ($v_bytes << 8) | Ord($v_byte);

        if ($v_bytes == 0x504b0506)
        {
          $v_pos++;
          break;
        }

        $v_pos++;
      }

      if ($v_pos == $v_size)
      {
        PclZip::privErrorLog(PCLZIP_ERR_BAD_FORMAT, "Unable to find End of Central Dir Record signature");
        return PclZip::errorCode();
      }
    }

    $v_binary_data = fread($this->zip_fd, 18);

    if (strlen($v_binary_data) != 18)
    {
      PclZip::privErrorLog(PCLZIP_ERR_BAD_FORMAT, "Invalid End of Central Dir Record size : ".strlen($v_binary_data));
      return PclZip::errorCode();
    }

    $v_data = unpack('vdisk/vdisk_start/vdisk_entries/ventries/Vsize/Voffset/vcomment_size', $v_binary_data);

    if ($v_data['comment_size'] != 0)
      $p_central_dir['comment'] = fread($this->zip_fd, $v_data['comment_size']);
    else
      $p_central_dir['comment'] = '';

    $p_central_dir['entries'] = $v_data['entries'];
    $p_central_dir['disk_entries'] = $v_data['disk_entries'];
    $p_central_dir['offset'] = $v_data['offset'];
    $p_central_dir['size'] = $v_data['size'];
    $p_central_dir['disk'] = $v_data['disk'];
    $p_central_dir['disk_start'] = $v_data['disk_start'];

    return $v_result;
  }

  function privDirCheck($p_dir, $p_is_dir=false)
  {
    $v_result = 1;

    if (($p_is_dir) && (substr($p_dir, -1)=='/'))
    {
      $p_dir = substr($p_dir, 0, strlen($p_dir)-1);
    }
    if ((is_dir($p_dir)) || ($p_dir == ""))
    {
      return 1;
    }

    $p_parent_dir = dirname($p_dir);

    if ($p_parent_dir != $p_dir)
    {
      if ($p_parent_dir != "")
      {
        if (($v_result = $this->privDirCheck($p_parent_dir)) != 1)
        {
          return $v_result;
        }
      }
    }

    if (!@mkdir($p_dir, 0777))
    {
      PclZip::privErrorLog(PCLZIP_ERR_DIR_CREATE_FAIL, "Unable to create directory '$p_dir'");
      return PclZip::errorCode();
    }
    return $v_result;
  }

  function privDisableMagicQuotes()
  {
    $v_result=1;

    if (   (!function_exists("get_magic_quotes_runtime"))
	    || (!function_exists("set_magic_quotes_runtime"))) {
      return $v_result;
	}

    if ($this->magic_quotes_status != -1) {
      return $v_result;
	}

	$this->magic_quotes_status = @get_magic_quotes_runtime();
	if ($this->magic_quotes_status == 1) {
	  @set_magic_quotes_runtime(0);
	}
    return $v_result;
  }

  function privSwapBackMagicQuotes()
  {
    $v_result=1;

    if (   (!function_exists("get_magic_quotes_runtime"))
	    || (!function_exists("set_magic_quotes_runtime"))) {
      return $v_result;
	}

    if ($this->magic_quotes_status != -1) {
      return $v_result;
	}

	if ($this->magic_quotes_status == 1) {
  	  @set_magic_quotes_runtime($this->magic_quotes_status);
	}
    return $v_result;
  }

  function privErrorLog($p_error_code=0, $p_error_string='')
  {
      $this->error_code = $p_error_code;
      $this->error_string = $p_error_string;
  }
}

?>
