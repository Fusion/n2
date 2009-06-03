#!/usr/bin/perl
use strict;
use warnings;
use File::Copy;

# WARNING: If you are not an active NBBS developer, you can stop reading and close this file :)
# This is a low-intelligence script to update php file headers...
# (c) C. Ravenscroft, etc, etc.

use constant
{
    RW_LINK   => 1,
    RW_ACTION => 2
};

sub reencode
{
	my $link = shift;
	my $in_code = shift;
	# Only convert regular links not javascript etc.
	if(0 != index($link, "./index.php", 0) && 0 != index($link, '{$url}', 0))
	{
		if(1 == $in_code)
		{
			return '\"' . $link;
		}
		else
		{
			return '"' . $link;
		}
	}
	$link =~ s/\.\/index\.php\?//;
#	$link = join('/', split(/\&amp;/, $link));
#	$link = join('/', split(/=/, $link));

#	ID: Thread id -> Thread name
	if(-1 != index($link, '$obj->getThreadId()}', 0))
	{
		$link =~ s/\{\$SESSURL\}/&amp;title=\{\$obj->getUrlizedName\(\)\}\{\$SESSURL\}/g;
	}
	if(-1 != index($link, '$Thread->getThreadId()}', 0))
	{
		$link =~ s/\{\$SESSURL\}/&amp;title=\{\$Thread->getUrlizedName\(\)\}\{\$SESSURL\}/g;
	}
	if(-1 != index($link, '$forum->info[forumid]', 0))
	{
		$link =~ s/\{\$SESSURL\}/&amp;title=\{\$forum->info\[urlizedname\]\}\{\$SESSURL\}/g;
	}

	my $ret;
	if(1 == $in_code)
	{
		$ret = '\"" . n2link("' . $link . '") . "';
	}
	else
	{
		$ret = '"<n2link(' . $link . ')>';
	}
	return $ret;
}

sub rewritelink
{
	my $line = shift;
	my $rwwhat = shift;
	my $ret = '';
	my $L = length($line);
	my $idx = 0;
	my $startidx = 0;
	my $p;
	do
	{
		if(RW_LINK == $rwwhat)
		{
			$p = index($line, "<a href=", $idx);
		}
		else
		{
			$p = index($line, " action=", $idx);
		}
		if(-1 != $p)
		{
			$ret .= substr($line, $idx, 8+($p-$idx));
			$idx = $p + 8;
			my $c = substr($line, $idx, 1);
			my $in_code = ("\\" eq $c ? 1 : 0);
			if(1 == $in_code)
			{
				$idx ++;
				$c = substr($line, $idx, 1);
			}
			if(!('"' eq $c))
			{
				die "\nERROR: expecting url starting with a double quote\n\n";
			}
			++ $idx;
			$startidx = $idx;
			while($idx < $L)
			{
				$c = substr($line, $idx, 1);
				if("\\" eq $c && 1 == $in_code && '"' eq substr($line, $idx+1, 1))
				{
					# Found the end of out link
					$ret .= reencode(substr($line, $startidx, $idx-$startidx), $in_code);
					last;
				}
				if('"' eq $c)
				{
					$ret .= reencode(substr($line, $startidx, $idx-$startidx), $in_code);
					last;
				}
				$idx ++;
			}
			if($idx == $L)
			{
				die "\nERROR: unable to find url end\n\n";
			}
		}
		else
		{
			$ret .= substr($line, $idx);
		}
	}
	while(-1 != $p);
	return $ret;
}

sub rewritesrc
{
	my $line = shift;
	$line =~ s/ src=\\"\.\// src=\\"".HOME."/g;
	return $line;
	$line =~ s/ src="\.\// src="<home>/g;
	return $line;
}

sub rewriteurl
{
	my $line = shift;
	my $in_code = (-1 != index($line, '\"', 0) ? 1 : 0);
	if(1 == $in_code)
	{
		$line =~ s/import url\(\.\//import url\(".HOME."/g;
	}
	else
	{
		$line =~ s/import url\(\.\//import url\(<home>/g;
	}
	return $line;
}

sub updatefilelinks
{
	my $filename = shift;
	open(CURFILE, "<", $filename) or die "Unable to read $filename: $!\n";
	open(OUTFILE, ">tmp") or die "Unable to create temporary file: $!\n";
	while(<CURFILE>)
	{
		my $line = $_;

		if($line =~ /\<a href=/)
		{
			$line = rewritelink($line, RW_LINK);
		}

		if($line =~ /\ action=/)
		{
			$line = rewritelink($line, RW_ACTION);
		}

		if($line =~ / src=/)
		{
			$line = rewritesrc($line);
		}

		if($line =~ /import url\(\.\//)
		{
			$line = rewriteurl($line);
		}

		print OUTFILE $line;
	}
	close(OUTFILE);
	close(CURFILE);

	copy("tmp", $filename) or die "Unable to replace $filename: $!\n";
	unlink("tmp");
}

sub processdir
{
	my $curdir = shift;
	print "[$curdir]\n";
	my @files = <${curdir}/*.xml>;
	foreach my $filename (@files)
	{
		print "- ", $filename, "\n";
		&updatefilelinks($filename);
		exit;
	}
}

#
# main
#

&processdir("install");
print "\n ----------\n| All done |\n ----------\n\n";
