<?php
use think\facade\Request;
use think\facade\Route;

class Page{
	public $firstRow;  //起始行数
	private $totalRows;  //总行数
	private $pageSize;  //列表每页显示行数
	private $parameter;  //分页跳转时要带的参数
	private $nowPage = 1;  //当前页码
	private $totalPages;  //分页总页面数
	private $p = 'page';  //分页参数名
	private $url = '';  //当前链接URL
	
	public function __construct($totalRows,$pageSize=20,$url='',$parameter=[]){
		$this->totalRows = $totalRows;
		$this->pageSize = $pageSize;
		$this->parameter = empty($parameter) ? Request::get('') : $parameter;
		$this->nowPage = !Request::get($this->p) ? 1 : intval(Request::get($this->p));
		$this->nowPage = $this->nowPage>0 ? $this->nowPage : 1;
		$this->firstRow = $this->pageSize * ($this->nowPage - 1);
		$this->parameter[$this->p] = '[PAGE]';
		$parameter = '';
		foreach ($this->parameter as $key=>$value){
			$parameter .= '&'.$key.'='.$value;
		}
		$this->url = ($url ? $url : Route::buildUrl('/'.parse_name(Request::controller()).'/'.parse_name(Request::action()))).'?'.substr($parameter,1);
		$this->totalPages = ceil($this->totalRows / $this->pageSize);
		if (!empty($this->totalPages) && $this->nowPage>$this->totalPages) $this->nowPage = $this->totalPages;
	}
	
	private function url($page){
		return str_replace('[PAGE]',$page,$this->url);
	}
	
	public function show(){
		$up_row = $this->nowPage - 1;
		$down_row = $this->nowPage + 1;
		$html = '<form method="get" action="" class="page"><p>'.$this->nowPage.'/'.$this->totalPages.'页（每页'.$this->pageSize.'条/共'.$this->totalRows.'条） | '.($this->nowPage>1 ? '<a href="'.$this->url(1).'">首页</a> |' : '首页 |').' '.($up_row > 0 ? '<a href="'.$this->url($up_row).'">上一页</a> |' : '上一页 |').' '.($down_row<=$this->totalPages ? '<a href="'.$this->url($down_row).'">下一页</a> |' : '下一页 |').' '.($this->nowPage<$this->totalPages ? '<a href="'.$this->url($this->totalPages).'">尾页</a>' : '尾页').' <select class="select" onchange="location.href=this.options[this.selectedIndex].value">';
		for ($i=1;$i<=$this->totalPages;$i++){
			$html .= '<option value="'.$this->url($i).'" '.($i==$this->nowPage ? 'selected' : '').'>第'.$i.'页</option>';
		}
		$html .= '</select></p></form>';
		return $html;
	}
	
	public function show2(){
		$up_row = $this->nowPage - 1;
		$down_row = $this->nowPage + 1;
		$html = '<form method="get" action="" class="page"><p>'.($this->nowPage>1 ? '<a href="'.$this->url(1).'">首页</a>' : '<a href="javascript:;" class="active">首页</a>').' '.($up_row > 0 ? '<a href="'.$this->url($up_row).'">上一页</a>' : '<a href="javascript:;" class="disabled">上一页</a>').' '.($down_row<=$this->totalPages ? '<a href="'.$this->url($down_row).'">下一页</a>' : '<a href="javascript:;" class="disabled">下一页</a>').' ';
		if ($this->nowPage < $this->totalPages){
			$html .= '<a href="'.$this->url($this->totalPages).'">尾页</a>';
		}elseif ($this->totalPages == 1){
			$html .= '<a href="javascript:;" class="disabled">尾页</a>';
		}else{
			$html .= '<a href="javascript:;" class="active">尾页</a>';
		}
		$html .= ' <select class="select" onchange="location.href=this.options[this.selectedIndex].value">';
		for ($i=1;$i<=$this->totalPages;$i++){
			$html .= '<option value="'.$this->url($i).'" '.($i==$this->nowPage ? 'selected' : '').'>第'.$i.'页</option>';
		}
		$html .= '</select></p><p>'.$this->nowPage.'/'.$this->totalPages.'页（每页'.$this->pageSize.'条/共'.$this->totalRows.'条）</p></form>';
		return $html;
	}
}