<?php
class Pagination{
	
	private $totalItems;					
	private $totalItemsPerPage		= 1;	
	private $pageRange				= 5;	
	private $totalPage;						
	private $currentPage			= 1;	
	
	public function __construct($totalItems, $pagination){
		$this->totalItems			= $totalItems;
		$this->totalItemsPerPage	= $pagination['totalItemsPerPage'];
		
		if($pagination['pageRange'] %2 == 0) $pagination['pageRange'] = $pagination['pageRange'] + 1;
		
		$this->pageRange			= $pagination['pageRange'];
		$this->currentPage			= $pagination['currentPage'];
		$this->totalPage			= ceil($totalItems/$pagination['totalItemsPerPage']);
	}
	
	public function showPagination($link = null){
		// Pagination
		$paginationHTML = '';
		if($this->totalPage > 1){
			$start 	= '<div class="button2-right off"><div class="start"><span>Start</span></div></div>';
			$prev 	= '<div class="button2-right off"><div class="prev"><span>Pre</span></div></div>';
			if($this->currentPage > 1){
				$start 	= '<div class="button2-right"><div class="start"><a onclick="javascript:changePage(1)" href="#">Start</a></div></div>';
				$prev 	= '<div class="button2-right"><div class="prev"><a onclick="javascript:changePage('.($this->currentPage-1).')" href="#">Previous</a></div></div>';
			}
		
			$next 	= '<div class="button2-left off"><div class="next"><span>Next</span></div></div>';
			$end 	= '<div class="button2-left off"><div class="end"><span>End</span></div></div>';
			if($this->currentPage < $this->totalPage){
				$next 	= '<div class="button2-left"><div class="next"><a onclick="javascript:changePage('.($this->currentPage+1).')" href="#">Next</a></div></div>';
				$end 	= '<div class="button2-left"><div class="end"><a href="#" onclick="javascript:changePage('.$this->totalPage.')">End</a></div></div>';
			}
		
			if($this->pageRange < $this->totalPage){
				if($this->currentPage == 1){
					$startPage 	= 1;
					$endPage 	= $this->pageRange;
				}else if($this->currentPage == $this->totalPage){
					$startPage		= $this->totalPage - $this->pageRange + 1;
					$endPage		= $this->totalPage;
				}else{
					$startPage		= $this->currentPage - ($this->pageRange-1)/2;
					$endPage		= $this->currentPage + ($this->pageRange-1)/2;
		
					if($startPage < 1){
						$endPage	= $endPage + 1;
						$startPage = 1;
					}
		
					if($endPage > $this->totalPage){
						$endPage	= $this->totalPage;
						$startPage 	= $endPage - $this->pageRange + 1;
					}
				}
			}else{
				$startPage		= 1;
				$endPage		= $this->totalPage;
			}

			$listPages = '<div class="button2-left"><div class="page">';
			for($i = $startPage; $i <= $endPage; $i++){
				if($i == $this->currentPage) {
					$listPages .= '<span>'.$i.'</span>';
				}else{
					$listPages .= '<a href="#" onclick="javascript:changePage('.$i.')">'.$i.'</a>';
				}
			}
			$listPages .= '</div></div>';
			$endPagination	= '<div class="limit">Page '.$this->currentPage.' of '.$this->totalPage.'</div>';
			$paginationHTML = '<div class="pagination">' . $start . $prev . $listPages . $next . $end . $endPagination . '</div>';
		}else{
			$paginationHTML = '';
		}
		return $paginationHTML;
	}

	public function showPaginationPublic($link = null){
		// Pagination
		$paginationHTML = '';
		if($this->totalPage > 1){
			$prev 	= '<li><a><i class="fa fa-angle-left"></i></a></li>';
			if($this->currentPage > 1){
				$prev 	= '<li><a href="#" onclick="javascript:changePage('.($this->currentPage-1).')"><i class="fa fa-angle-left"></i></a></li>';
			}
		
			$next 	= '<li><a href="#"><i class="fa fa-angle-right"></i></a></li>';
			if($this->currentPage < $this->totalPage){
				$next 	= '<li><a href="#" onclick="javascript:changePage('.($this->currentPage+1).')"><i class="fa fa-angle-right"></i></a></li>';
			}
		
			if($this->pageRange < $this->totalPage){
				if($this->currentPage == 1){
					$startPage 	= 1;
					$endPage 	= $this->pageRange;
				}else if($this->currentPage == $this->totalPage){
					$startPage		= $this->totalPage - $this->pageRange + 1;
					$endPage		= $this->totalPage;
				}else{
					$startPage		= $this->currentPage - ($this->pageRange-1)/2;
					$endPage		= $this->currentPage + ($this->pageRange-1)/2;
		
					if($startPage < 1){
						$endPage	= $endPage + 1;
						$startPage = 1;
					}
		
					if($endPage > $this->totalPage){
						$endPage	= $this->totalPage;
						$startPage 	= $endPage - $this->pageRange + 1;
					}
				}
			}else{
				$startPage		= 1;
				$endPage		= $this->totalPage;
			}

			$listPages = '';
			for($i = $startPage; $i <= $endPage; $i++){
				if($i == $this->currentPage) {
					$listPages .= '<li class="active">'.$i.'</li>';
				}else{
					$listPages .= '<li><a href="#" onclick="javascript:changePage('.$i.')" >'.$i.'</a></li>';
				}
			}
			$endPagination	= '<b style="margin: 5px 10px">Page '.$this->currentPage.' of '.$this->totalPage.'</b>';
			$paginationHTML = '<div class="store-filter clearfix"><ul class="store-pagination">' . $prev . $listPages . $next . $endPagination . '</ul></div>';
		}
		return $paginationHTML;
	}
}