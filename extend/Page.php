<?php

namespace extend;

use think\facade\Request;

class Page
{
    public $firstRow;  //起始行数
    private $totalRows;  //总行数
    private $pageSize;  //列表每页显示行数
    private $parameter;  //分页跳转时要带的参数
    private $nowPage = 1;  //当前页码
    private $totalPages;  //分页总页面数
    private $p = 'page';  //分页参数名
    private $url = '';  //当前链接URL

    public function __construct($totalRows, $pageSize = 20, $url = '', $parameter = [])
    {
        $this->totalRows = $totalRows;
        $this->pageSize = $pageSize;
        $this->parameter = empty($parameter) ? Request::get('') : $parameter;
        $this->nowPage = !Request::get($this->p) ? 1 : intval(Request::get($this->p));
        $this->nowPage = $this->nowPage > 0 ? $this->nowPage : 1;
        $this->firstRow = $this->pageSize * ($this->nowPage - 1);
        $this->parameter[$this->p] = '[PAGE]';
        $parameter = '';
        foreach ($this->parameter as $key => $value) {
            $parameter .= '&' . $key . '=' . $value;
        }
        $this->url = ($url ? $url : (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on' ? 'https' : 'http') . '://' .
                $_SERVER['HTTP_HOST'] . explode('?', $_SERVER['REQUEST_URI'])[0]) . '?' . substr($parameter, 1);
        $this->totalPages = ceil($this->totalRows / $this->pageSize);
        if (!empty($this->totalPages) && $this->nowPage > $this->totalPages) {
            $this->nowPage = $this->totalPages;
        }
    }

    private function url($page)
    {
        return str_replace('[PAGE]', $page, $this->url);
    }

    public function show()
    {
        $upRow = $this->nowPage - 1;
        $downRow = $this->nowPage + 1;
        $html = '<form method="get" action="" class="page layui-form"><p>' . $this->nowPage . '/' . $this->totalPages .
            '页（每页' . $this->pageSize . '条/共' . $this->totalRows . '条） | ' . ($this->nowPage > 1 ? '<a href="' .
                $this->url(1) . '">首页</a> |' : '首页 |') . ' ' . ($upRow > 0 ? '<a href="' . $this->url($upRow) .
                '">上一页</a> |' : '上一页 |') . ' ' . ($downRow <= $this->totalPages ? '<a href="' . $this->url($downRow) .
                '">下一页</a> |' : '下一页 |') . ' ' . ($this->nowPage < $this->totalPages ? '<a href="' .
                $this->url($this->totalPages) . '">尾页</a>' : '尾页') .
            ' <select lay-filter="page" lay-search>';
        for ($i = 1; $i <= $this->totalPages; $i++) {
            $html .= '<option value="' . $this->url($i) . '" ' . ($i == $this->nowPage ? 'selected' : '') . '>第' . $i .
                '页</option>';
        }
        $html .= '</select></p></form>';
        return str_replace('?' . $this->p . '=1', '', $html);
    }
}
