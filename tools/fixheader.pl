#!/usr/bin/perl
use strict;
use warnings;
use File::Copy;

# WARNING: If you are not an active NBBS developer, you can stop reading and close this file :)
# This is a low-intelligence script to update php file headers...
# (c) C. Ravenscroft, etc, etc.

use constant
{
	START     => 0,
	IN_HEADER => 1,
	COPY      => 2
};

my $licensetext;

sub initlicense
{
	open(CURFILE, "<tools/licenseheader.txt") or die "Unable to read license file: $!\n";
	$licensetext = do { local $/; <CURFILE> };
	close(CURFILE);
}

sub updatefileheader
{
	my $filename = shift;
	my $state = START;
	open(CURFILE, "<", $filename) or die "Unable to read $filename: $!\n";
	open(OUTFILE, ">tmp") or die "Unable to create temporary file: $!\n";
	while(<CURFILE>)
	{
		my $line = $_;

		if(START == $state)
		{
			if($line =~ /^\/\*/)
			{
				$state = IN_HEADER;
			}
			else
			{
				print OUTFILE $line;
			}
		}
		elsif(IN_HEADER == $state)
		{
			if($line =~ /\*\//)
			{
				$state = COPY;
				print OUTFILE $licensetext;
			}
		}
		else
		{
			print OUTFILE $line;
		}
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
	my @files = <${curdir}/*.php>;
	foreach my $filename (@files)
	{
		print "- ", $filename, "\n";
		&updatefileheader($filename);
	}
}

sub processdirandrecurse
{
	my $curdir = shift;
	&processdir($curdir);
	my @files = <${curdir}/*>;
	foreach my $file (@files)
	{
		next if $file eq "." or $file eq "..";
		if(-d $file)
		{
			&processdirandrecurse($file);
		}
	}
}

#
# main
#

&initlicense;
&processdir(".");
&processdir("admin");
&processdir("cache");
&processdir("cron");
&processdir("exports");
&processdir("includes");
&processdir("install");
&processdir("language");
&processdirandrecurse("lib");
&processdir("scripts");
&processdirandrecurse("sql");
&processdir("user");

print "\n ----------\n| All done |\n ----------\n\n";
