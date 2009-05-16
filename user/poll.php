<?php
/*
 * wtcBB Community Software (Open Source Freeware Version)
 * Copyright (C) 2004-2007. All Rights Reserved. wtcBB Software Solutions.
 * http://www.wtcbb.com
 *
 * Licensed under the terms of the GNU Lesser General Public License:
 * http://www.wtcbb.com/wtcbb-license-general-public-license 
 *
 * For support visit: http://forums.wtcbb.com
 *
 * Powered by wtcBB - http://www.wtcbb.com
 * Protected by ChargebackFile - http://www.chargebackfile.com
 * 
 */
// ************************************************** \\
## ************************************************** ##
## ************************************************** ##
## **************** MANAGING POLLS ****************** ##
## ************************************************** ##
## ************************************************** ##
// ************************************************** \\
echo "hai";

// do we have a pollid?
if($_GET['poll']) {
	$Poll = new Poll($_GET['poll']);
	$Thread = new Thread($Poll->getThreadId());
}

// just a thread id
else if($_GET['t']) {
	$Poll = NULL; // we don't have a poll yet
	$Thread = new Thread($_GET['t']);
}

// wrong-o!
else {
	new WtcBBException($lang['error_noInfo']);
}

// easy to access IDs
$threadid = $Thread->getThreadId();
$forumid = $Thread->getForumId();

// initiate forum info
Forum::init(); // initiates forums
ForumPerm::init(); // initiates forum permissions array
Moderator::init(); // initiates moderators array

// create forum obj
$FORUM = $forums[$forumid]; // easy to access object

// make sure forum exists
if(!isset($forums[$forumid])) {
	new WtcBBException($lang['error_forum_invalidForum']);
}

// this checks forum permissions, usergroups, and user forum access
if(!$User->canViewForum($forumid) OR !$Thread->canView()) {
	new WtcBBException('perm');
}

// forum is a link?
$FORUM->goToLink();

// trying to perform an action?
if($Thread->isDeleted()) {
	new WtcBBException($lang['user_thread_delMessage']);
}

// moved?
if($Thread->movedTo()) {
	//  update views and make read
	$Thread->update(Array('views' => ($Thread->getViews() + 1)));

	// insert read... if need be...
	if(LOGIN) {
		new Query($query['read_threads']['insert'], Array(
														1 => $User->info['userid'],
														2 => $Thread->getThreadId(),
														3 => NOW
													));
	}

	new Redirect('./index.php?file=thread&t=' . $Thread->movedTo() . $SESSURL);
}

// edit poll (or vote)
if($Poll instanceof Poll) {
	// we might be voting...
	if($_GET['do'] == 'vote') {
		// Define AREA
		define('AREA', 'USER-VOTEPOLL');
		require_once('./includes/sessions.php');

		// make sure we have perms... and hasn't voted
		if(!LOGIN OR !$Poll->canVote() OR $Poll->hasVoted()) {
			new WtcBBException('perm');
		}

		// try to find voting choice in options...
		$update['polloptions'] = $Poll->getPollOptions();
		$addedVotes = 0;

		foreach($update['polloptions'] as $key => $info) {
			// multiple?
			if($Poll->isMultiple()) {
				if(!is_array($_POST['choice'])) {
					break;
				}

				foreach($_POST['choice'] as $choice) {
					if($choice == $info['id']) {
						// update votes and voters
						$update['polloptions'][$key]['votes']++;
						$update['polloptions'][$key]['voters'][] = $User->info['username'];

						$addedVotes++;

						break;
					}
				}
			}

			else {
				if($_POST['choice'] == $info['id']) {
					// update votes and voters
					$update['polloptions'][$key]['votes']++;
					$update['polloptions'][$key]['voters'][] = $User->info['username'];

					$addedVotes++;

					break;
				}
			}
		}

		// uh oh...
		if(!$addedVotes) {
			new WtcBBException('error_forum_invalidChoice');
		}

		// increment total number of votes...
		$update['votes'] = $Poll->getNumVotes() + $addedVotes;

		// reserialize!
		$update['polloptions'] = serialize($update['polloptions']);

		// now do the update!
		$Poll->update($update);

		new WtcBBThanks($lang['thanks_pollvoted']);
	}

	// deleting!
	else if($_GET['do'] == 'delete') {
		// moderator perms only
		if(!$User->modAction('canEditPolls', $Poll->getForumId())) {
			new WtcBBException('perm');
		}

		// do the delete!
		$Poll->destroy();

		new WtcBBThanks($lang['thanks_deletepoll']);
	}

	// editing
	else {
		// Define AREA
		define('AREA', 'USER-EDITPOLL');
		require_once('./includes/sessions.php');

		// moderator perms only
		if(!$User->modAction('canEditPolls', $Poll->getForumId())) {
			new WtcBBException('perm');
		}

		// no error... yet!
		$error = '';

		if($_POST) {
			if($_POST['update']) {
				$numPollOptions = $_POST['poll']['options'];
			}

			// time to update... YUCK...
			else {
				$_POST['poll']['title'] = trim($_POST['poll']['title']);

				if(empty($_POST['poll']['title'])) {
					$error = new WtcBBException($lang['error_forum_noPollTitle'], false);
				}

				else {
					$update['title'] = wtcspecialchars($_POST['poll']['title']);
					$update['options'] = 0; // set later, can't rely on user data
					$update['multiple'] = $_POST['poll']['multiple'];
					$update['public'] = $_POST['poll']['public'];
					$update['disabled'] = $_POST['poll']['disabled'];
					$update['timeout'] = $_POST['poll']['timeout'];
					$update['votes'] = 0; // recaclulate this too

					// we need to recaclulate vote and option counts
					$optionCount = 0;

					// okay, now go through and update poll options...
					foreach($_POST['polloptions'] as $optNum => $info) {
						$info = array_map('trim', $info);

						// wtf?
						if(empty($info['text'])) {
							continue;
						}

						// we're okay with the option text
						$update['pollOptions'][$optNum]['text'] = wtcspecialchars($info['text']);

						// voters... HMMM... (we don't have user ids)
						$voters = preg_split('/(\s+)?,(\s+)?/s', $info['voters']);

						// now add in... (and count, for votes)
						$votes = 0;

						if(is_array($voters) AND count($voters)) {
							foreach($voters as $username) {
								$username = trim($username);

								if(empty($username)) {
									continue;
								}

								$update['pollOptions'][$optNum]['voters'][] = wtcspecialchars($username);
								$votes++; $totalVotes++;
							}
						}

						else {
							$update['pollOptions'][$optNum]['voters'] = '';
						}

						// set new votes
						$update['pollOptions'][$optNum]['votes'] = $votes;

						// generate new ID... as we could have a new option
						$update['pollOptions'][$optNum]['id'] = md5(time() . microtime() . $numOpt . $info['text']);

						$optionCount++;
					}

					// yikes
					if(!$optionCount) {
						new WtcBBException($lang['error_forum_noPollOptions']);
					}

					// now set new option counts
					$update['options'] = $optionCount;
					$update['votes'] = $totalVotes;

					// don't forget to serialize!
					$update['pollOptions'] = serialize($update['pollOptions']);

					// now do the update
					$Poll->update($update);

					new WtcBBThanks($lang['thanks_pollupdate'], './index.php?file=thread&amp;t=' . $Poll->getThreadId() . $SESSURL);
				}
			}

			if($error instanceof WtcBBException) {
				$error = $error->dump();
				$numPollOptions = $_POST['poll']['options'];
			}

			// sanity check
			if(is_array($_POST['poll'])) {
				$_POST['poll'] = array_map('wtcspecialchars', $_POST['poll']);
			}

			if(is_array($_POST['polloptions'])) {
				$_POST['polloptions'] = array_map('wtcspecialchars', $_POST['polloptions']);
			}
		}

		else {
			$_POST['poll'] = $Poll->getInfo();
			$_POST['polloptions'] = $Poll->getPollOptions();
		}

		// make sure the number of poll options isn't greater than max, not a number, or less than 1
		if(!isset($numPollOptions) OR !is_numeric($numPollOptions) OR $numPollOptions < 1 OR $numPollOptions > $bboptions['pollLimit']) {
			$numPollOptions = count($_POST['polloptions']);
		}

		// format a date for today
		$todayDate = new WtcDate('date', $Poll->getTimeline(), false);

		// create the "number of options" bits
		$numOptBits = '';

		for($num = 1; $num <= $bboptions['pollLimit']; $num++) {
			$temp = new StyleFragment('poll_optselectbit');
			$numOptBits .= $temp->dump();
		}

		// now create the actual options bit
		$optionBits = ''; $ALT = 1;

		for($optNum = 1; $optNum <= $numPollOptions; $optNum++) {
			$info = $_POST['polloptions'][$optNum];

			// form voter bits
			$voters = ''; $before = '';

			if(is_array($info['voters'])) {
				foreach($info['voters'] as $username) {
					$voters .= $before . $username;
					$before = ', ';
				}
			}

			else if(!empty($info['voters'])) {
				$voters = $info['voters'];
			}

			$temp = new StyleFragment('poll_edit_optbit');
			$optionBits .= $temp->dump();

			if($ALT === 1) {
				$ALT = 2;
			}

			else {
				$ALT = 1;
			}
		}

		// create navigation
		$Nav = new Navigation(Array(
								$Thread->getName() => './index.php?file=thread&amp;t=' . $Thread->getThreadId(),
								$lang['user_thread_poll_manage'] => ''
							), 'forum');

		$header = new StyleFragment('header');
		$content = new StyleFragment('poll_edit');
		$footer = new StyleFragment('footer');

		$header->output();
		$content->output();
		$footer->output();
	}
}

// create poll
else {
	// Define AREA
	define('AREA', 'USER-CREATEPOLL');
	require_once('./includes/sessions.php');

	// perms!
	if(!$Thread->canPolls()) {
		new WtcBBException('perm');
	}

	// make sure we don't already have a poll...
	if($Thread->isPoll()) {
		new WtcBBException($lang['error_forum_doublePoll']);
	}

	// validated below
	$numPollOptions = $_GET['options'];
	$error = '';

	// do add poll...
	// but wait, are we just updating the number of poll options?
	if($_POST) {
		if($_POST['update']) {
			$numPollOptions = $_POST['poll']['options'];
		}

		// now we're going to add
		else {
			$_POST['poll']['title'] = trim($_POST['poll']['title']);

			if(empty($_POST['poll']['title'])) {
				$error = new WtcBBException($lang['error_forum_noPollTitle'], false);
			}

			else {
				// start forming our insert array
				$_POST['poll'] = array_map('wtcspecialchars', $_POST['poll']);
				$_POST['polloptions'] = array_map('wtcspecialchars', $_POST['polloptions']);

				$insert['forumid'] = $FORUM->info['forumid'];
				$insert['threadid'] = $Thread->getThreadId();
				$insert['title'] = $_POST['poll']['title'];
				$insert['poll_timeline'] = NOW;
				$insert['options'] = $_POST['poll']['options'];
				$insert['multiple'] = $_POST['poll']['multiple'];
				$insert['public'] = $_POST['poll']['public'];
				$insert['votes'] = 0;
				$insert['timeout'] = $_POST['poll']['timeout'];

				// only change disabled state if moderator...
				if($User->isMod($FORUM->info['forumid'])) {
					$insert['disabled'] = $_POST['poll']['disabled'];
				}

				else {
					$insert['disabled'] = 0;
				}

				// now formulate poll options...
				// we already know it's an array, or else we wouldn't be here
				// first remove empty options
				foreach($_POST['polloptions'] as $numOpt => $val) {
					$val = trim($val);

					if(empty($val)) {
						unset($_POST['polloptions'][$numOpt]);
						$insert['options']--;

						continue;
					}

					$_POST['polloptions'][$numOpt] = Array(
						'text' => $val,
						'id' => md5(time() . microtime() . $numOpt . $val),
						'votes' => 0,
						'voters' => ''
					);
				}

				// uh oh...
				if($insert['options'] <= 0) {
					new WtcBBException($lang['error_forum_noPollOptions']);
				}

				$insert['polloptions'] = serialize($_POST['polloptions']);

				// now do the insert
				$pollid = Poll::insert($insert);

				// now update the thread
				$Thread->update(Array('poll' => $pollid));

				// thanks
				new WtcBBThanks($lang['thanks_polladd'], './index.php?file=thread&amp;t=' . $Thread->getThreadId() . $SESSURL);
			}
		}

		if($error instanceof WtcBBException) {
			$error = $error->dump();
			$numPollOptions = $_POST['poll']['options'];
		}

		// sanity check
		if(is_array($_POST['poll'])) {
			$_POST['poll'] = array_map('wtcspecialchars', $_POST['poll']);
		}

		if(is_array($_POST['polloptions'])) {
			$_POST['polloptions'] = array_map('wtcspecialchars', $_POST['polloptions']);
		}
	}

	else {
		// set some default values
		$_POST['poll']['timeout'] = 0;
	}

	// make sure the number of poll options isn't greater than max, not a number, or less than 1
	if(!is_numeric($numPollOptions) OR $numPollOptions < 1 OR $numPollOptions > $bboptions['pollLimit']) {
		$numPollOptions = 2; // meh, why 2? who knows
	}

	// format a date for today
	$todayDate = new WtcDate('date', NOW, false);

	// create the "number of options" bits
	$numOptBits = '';

	for($num = 1; $num <= $bboptions['pollLimit']; $num++) {
		$temp = new StyleFragment('poll_optselectbit');
		$numOptBits .= $temp->dump();
	}

	// now create the actual options bit
	$optionBits = ''; $ALT = 1;

	for($optNum = 1; $optNum <= $numPollOptions; $optNum++) {
		$temp = new StyleFragment('poll_optbit');
		$optionBits .= $temp->dump();

		if($ALT === 1) {
			$ALT = 2;
		}

		else {
			$ALT = 1;
		}
	}

	// create navigation
	$Nav = new Navigation(Array(
							$Thread->getName() => './index.php?file=thread&amp;t=' . $Thread->getThreadId(),
							$lang['user_thread_poll_manage'] => ''
						), 'forum');

	$header = new StyleFragment('header');
	$content = new StyleFragment('poll');
	$footer = new StyleFragment('footer');

	$header->output();
	$content->output();
	$footer->output();
}

?>