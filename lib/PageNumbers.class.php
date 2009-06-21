<?php
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
// ************************************************** \\
## ************************************************** ##
## ************************************************** ##
## *************** PAGE NUMBERS CLASS *************** ##
## ************************************************** ##
## ************************************************** ##
// ************************************************** \\


class PageNumbers {
	private $curr, $elements, $perpage, $pageNumbers, $pages, $url, $slideFactor, $buttons;

	// Constructor
	public function __construct($currPage, $numElements, $elementsPerPage, $forceUrl = '', $useButtons = false) {
		$this->curr = $currPage;
		$this->elements = $numElements;
		$this->perpage = $elementsPerPage;
		$this->buttons = $useButtons;
		$this->slideFactor = 2;

		if(empty($forceUrl)) {
			$this->formUrl();
		}

		else {
			$this->url = $forceUrl;
		}

		$this->calcPages();
		$this->formPageNumbers();
	}

	// Public Methods
	public function getPageNumbers($bits = false) {
		global $lang, $curr, $pages, $retval;

		$retval = '';

		// loop through and get our page numbers...
		if(is_array($this->pageNumbers)) {
			foreach($this->pageNumbers as $key => $html) {
				// special...
				if(!is_numeric($key)) {
					$retval .= $html;
				}

				else {
					$retval .= $html;
				}
			}
		}

		// if there's only page number one... blank it out
		if(count($this->pageNumbers) <= 1) {
			return '&nbsp;';
		}

		if(ADMIN) {
			return '(' . $lang['global_page'] . ' ' . $this->curr . ' ' . $lang['global_of'] . ' ' . $this->pages . ') ' . $retval;
		}

		else {
			$curr = $this->curr;
			$pages = $this->pages;

			if($bits) {
				$temp = new StyleFragment('pagebits');
			}

			else {
				$temp = new StyleFragment('page');
			}

			// remove trailing space too
			return preg_replace('/\s*(\))?<\/span>/', '$1</span>', $temp->dump());
		}
	}

	// has pages
	public function hasPages() {
		if($this->elements > $this->perpage) {
			return true;
		}

		return false;
	}


	// Private Methods
	private function formPageNumbers() {
		// find start and end
		$start = $this->curr - $this->slideFactor;
		$end = $this->curr + $this->slideFactor;

		// some more exceptions...
		if($start < 1) {
			$start = 1;
		}

		// end is too late...
		if($end > $this->pages) {
			$end = $this->pages;
		}

		// do we need these?
		if($start != 1) {
			$this->pageNumbers['first'] = $this->getFirstHTML();
			$this->pageNumbers['prev'] = $this->getPrevHTML();
		}

		// loop through pages, assign html to each one
		for($i = $start; $i <= $end; $i++) {
			$this->pageNumbers[$i] = (($this->curr == $i) ? $this->getCurrHTML() : $this->getNumberHTML($i));
		}

		// do we need these?
		if($end != $this->pages) {
			$this->pageNumbers['next'] = $this->getNextHTML();
			$this->pageNumbers['last'] = $this->getLastHTML();
		}
	}

	// forms the URL so we can tack on page var
	private function formUrl() {
		// just find &page and remove... always has query string
		$this->url = preg_replace('/&amp;page=[0-9]*/', '$1', $_SERVER['REQUEST_URI']);
	}

	private function calcPages() {
		$this->pages = $this->elements / $this->perpage;

		// not even?
		if(($this->elements % $this->perpage) != 0) {
			$this->pages = floor($this->pages) + 1;
		}
	}

	// html methods
	private function getNumberHTML($pageNum) {
		global $pageNumUse, $url;

		if(ADMIN) {
			if($this->buttons) {
				$retval = '<input type="button" class="button" value="' . $pageNum . '" onclick="window.location=\'' . n2link($this->url . '&amp;page=' . $pageNum) . '\';" /> ';
			}

			else {
				$retval = '<a href="' . n2link($this->url . '&amp;page=' . $pageNum . '">' . $pageNum) . '</a> ';
			}
		}

		else {
			$pageNumUse = $pageNum;
			$url = $this->url;
			$temp = new StyleFragment('page_number');
			$retval = $temp->dump();
		}

		return $retval;
	}

	private function getCurrHTML() {
		global $curr;

		if(ADMIN) {
			if($this->buttons) {
				$retval = '<input type="button" class="button disabled" value="' . $this->curr . '" disabled="disabled" /> ';
			}

			else {
				$retval = $this->curr . ' ';
			}
		}

		else {
			$curr = $this->curr;
			$temp = new StyleFragment('page_curr');
			$retval = $temp->dump();
		}

		return $retval;
	}

	private function getFirstHTML() {
		global $url;

		if(ADMIN) {
			if($this->buttons) {
				$retval = '<input type="button" class="button" value="&laquo;" onclick="window.location=\'' . n2link($this->url . '&amp;page=1') . '\';" /> ';
			}

			else {
				$retval = '<a href="' . n2link($this->url . '&amp;page=1') . '">&laquo;</a> ';
			}
		}

		else {
			$url = $this->url;
			$temp = new StyleFragment('page_first');
			$retval = $temp->dump();
		}

		return $retval;
	}

	private function getLastHTML() {
		global $url, $pages;

		if(ADMIN) {
			if($this->buttons) {
				$retval = '<input type="button" class="button" value="&raquo;" onclick="window.location=\'' . n2link($this->url . '&amp;page=' . $this->pages) . '\';" />';
			}

			else {
				$retval = '<a href="' . n2link($this->url . '&amp;page=' . $this->pages) . '">&raquo;</a>';
			}
		}

		else {
			$url = $this->url;
			$pages = $this->pages;
			$temp = new StyleFragment('page_last');
			$retval = $temp->dump();
		}

		return $retval;
	}

	private function getPrevHTML() {
		global $url, $curr;

		if(ADMIN) {
			if($this->buttons) {
				$retval = '<input type="button" class="button" value="&lt;" onclick="window.location=\'' . n2link($this->url . '&amp;page=' . ($this->curr - 1)) . '\';" /> ';
			}

			else {
				$retval = '<a href="' . n2link($this->url . '&amp;page=' . ($this->curr - 1)) . '">&lt;</a> ';
			}
		}

		else {
			$curr = ($this->curr - 1);
			$url = $this->url;
			$temp = new StyleFragment('page_prev');
			$retval = $temp->dump();
		}

		return $retval;
	}

	private function getNextHTML() {
		global $url, $curr;

		if(ADMIN) {
			if($this->buttons) {
				$retval = '<input type="button" class="button" value="&gt;" onclick="window.location=\'' . n2link($this->url . '&amp;page=' . ($this->curr + 1)) . '\';" /> ';
			}

			else {
				$retval = '<a href="' . n2link($this->url . '&amp;page=' . ($this->curr + 1)) . '">&gt;</a> ';
			}
		}

		else {
			$curr = ($this->curr + 1);
			$url = $this->url;
			$temp = new StyleFragment('page_next');
			$retval = $temp->dump();
		}

		return $retval;
	}
}

?>