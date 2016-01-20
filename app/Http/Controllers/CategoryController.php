<?php
namespace App\Http\Controllers;
use View;
use App\Models\Item;
use App\Models\ItemCat;
use App\Models\ItemAttr;
use Input;
use Request;
use DB;

class CategoryController extends Controller{
    function index() {
       // $this->getCatInfo(1);
      //  $this->filterAttrList('172,185,178');
      $attrList = $this->filterAttr();
     // var_dump($list[0]);exit;
     $ext = '';
      $itemList = $this->categoryGetItem($ext);
      return view('category.index', ['attrList' => $attrList,'itemList' => $itemList]);
    }
    
    /**
     * 获得指定分类下所有底层分类的ID
     *
     * @access  public
     * @param   integer     $cat        指定的分类ID
     * @return  string
     */
    function getChildren($cat = 0)
    {
        return 'g.cat_id ' . $this->db_create_in(array_unique(array_merge(array($cat), array_keys($this->cat_list($cat, 0, false)))));
    }
    
    
    //
    function filterAttr(){
        $attribute = 'attribute';
        $item_attr = 'item_attr';
        $item = 'item';
        $itemAttr = new ItemAttr;
        
        $attr = '172.185.178';
        $catAttr = '172,185,178'; 
        
        $filter_attr_str = isset($attr) ? htmlspecialchars(trim($attr)) : '0';
        
        $filter_attr_str = trim(urldecode($filter_attr_str));
        
        $filter_attr_str = preg_match('/^[\d\.]+$/',$filter_attr_str) ? $filter_attr_str : '';
        
        $filter_attr = empty($filter_attr_str) ? '' : explode('.', $filter_attr_str);
        
        $ext = ''; //商品查询条件扩展
   //     $children = $this->getChildren(1);
        
     //   var_dump($filter_attr);exit;
       
        if ($catAttr > 0)
        {
            $cat_filter_attr = explode(',', $catAttr);       //提取出此分类的筛选属性
            $all_attr_list = array();
 
            
            foreach ($cat_filter_attr AS $key => $value)
            {
                $sql = "SELECT a.attr_name FROM " . $attribute . " AS a, " . $item_attr . " AS ga, " . $item . " AS g WHERE  a.attr_id = ga.attr_id AND g.id = ga.item_id  AND a.attr_id='$value'";
           
                if($temp_name = DB::select($sql))
                {
                    $all_attr_list[$key]['filter_attr_name'] = $temp_name;
        
                    $sql = "SELECT a.attr_id, MIN(a.item_attr_id ) AS item_id, a.attr_value AS attr_value FROM " . $item_attr . " AS a, " . $item.
                    " AS g" .
                    " WHERE   g.id = a.item_id   ".
                    " AND a.attr_id='$value' ".
                    " GROUP BY a.attr_value";
       // echo $sql;exit;
                    $attr_list = DB::select($sql);
        
                    $temp_arrt_url_arr = array();
        
                    for ($i = 0; $i < count($cat_filter_attr); $i++)        //获取当前url中已选择属性的值，并保留在数组中
                    {
                        $temp_arrt_url_arr[$i] = !empty($filter_attr[$i]) ? $filter_attr[$i] : 0;
                    }
        
                    $temp_arrt_url_arr[$key] = 0;                           //“全部”的信息生成
                    $temp_arrt_url = implode('.', $temp_arrt_url_arr);
                    $all_attr_list[$key]['attr_list'][0]['attr_value'] = 'All';
                 //   $all_attr_list[$key]['attr_list'][0]['url'] = build_uri('category', array('cid'=>$cat_id, 'bid'=>$brand, 'price_min'=>$price_min, 'price_max'=>$price_max, 'filter_attr'=>$temp_arrt_url), $cat['cat_name']);
                    $all_attr_list[$key]['attr_list'][0]['selected'] = empty($filter_attr[$key]) ? 1 : 0;
        
                    foreach ($attr_list as $k => $v)
                    {
                      
                        $temp_key = $k + 1;
                        $temp_arrt_url_arr[$key] = $v->item_id;       //为url中代表当前筛选属性的位置变量赋值,并生成以‘.’分隔的筛选属性字符串
                        $temp_arrt_url = implode('.', $temp_arrt_url_arr);
        
                        $all_attr_list[$key]['attr_list'][$temp_key]['attr_value'] = $v->attr_value;
                     //   $all_attr_list[$key]['attr_list'][$temp_key]['url'] = build_uri('category', array('cid'=>$cat_id, 'bid'=>$brand, 'price_min'=>$price_min, 'price_max'=>$price_max, 'filter_attr'=>$temp_arrt_url), $cat['cat_name']);
        
                        if (!empty($filter_attr[$key]) AND $filter_attr[$key] == $v->item_id)
                        {
                            $all_attr_list[$key]['attr_list'][$temp_key]['selected'] = 1;
                        }
                        else
                        {
                            $all_attr_list[$key]['attr_list'][$temp_key]['selected'] = 0;
                        }
                    }
                }
        
            }
        
          return   $all_attr_list;
        //    header("Content-type: text/html; charset=utf-8");
         // var_dump($filter_attr_list[1]);exit;
            //  $smarty->assign('filter_attr_list',  $all_attr_list);
              
        }
      //  var_dump($filter_attr);exit;
        
    }
    
    /* 扩展商品查询条件 */
    function ext($filter_attr){
        
        if (!empty($filter_attr))
        {
            $ext_sql = "SELECT DISTINCT(b.item_id) FROM " . $item_attr . " AS a, " . $item_attr . " AS b " .  "WHERE ";
            $ext_group_goods = array();
            //var_dump($filter_attr);exit;
            foreach ($filter_attr AS $k => $v)                      // 查出符合所有筛选属性条件的商品id */
            {
                if (is_numeric($v) && $v !=0 &&isset($cat_filter_attr[$k]))
                {
                    $sql = $ext_sql . "b.attr_value = a.attr_value AND b.attr_id = " . $cat_filter_attr[$k] ." AND a.item_attr_id = " . $v;
                    //  echo $sql;exit;
                    $ext_group_goods = DB::select($sql);
                    //    var_dump($ext_group_goods);exit;
                    if($ext_group_goods){
                        // $ext .= ' AND ' . $this->db_create_in($ext_group_goods, 'g.id');
                    }
                     
                }
            }
        }
        
        $itemList = $this->categoryGetItem($ext);
        //var_dump($itemList);exit;
    }
    
    /**
     * 获得指定分类下的子分类的数组
     *
     * @access  public
     * @param   int     $cat_id     分类的ID
     * @param   int     $selected   当前选中分类的ID
     * @param   boolean $re_type    返回的类型: 值为真时返回下拉列表,否则返回数组
     * @param   int     $level      限定返回的级数。为0时返回所有级数
     * @param   int     $is_show_all 如果为true显示所有分类，如果为false隐藏不可见分类。
     * @return  mix
     */
    function cat_list($cat_id = 0, $selected = 0, $re_type = true, $level = 0, $is_show_all = true)
    {
        static $res = NULL;
    
    
        if (empty($res) == true)
        {
            return $re_type ? '' : array();
        }
    
        $options = cat_options($cat_id, $res); // 获得指定分类下的子分类的数组
    
        $children_level = 99999; //大于这个分类的将被删除
        if ($is_show_all == false)
        {
            foreach ($options as $key => $val)
            {
                if ($val['level'] > $children_level)
                {
                    unset($options[$key]);
                }
                else
                {
                    if ($val['is_show'] == 0)
                    {
                        unset($options[$key]);
                        if ($children_level > $val['level'])
                        {
                            $children_level = $val['level']; //标记一下，这样子分类也能删除
                        }
                    }
                    else
                    {
                        $children_level = 99999; //恢复初始值
                    }
                }
            }
        }
    
        /* 截取到指定的缩减级别 */
        if ($level > 0)
        {
            if ($cat_id == 0)
            {
                $end_level = $level;
            }
            else
            {
                $first_item = reset($options); // 获取第一个元素
                $end_level  = $first_item['level'] + $level;
            }
    
            /* 保留level小于end_level的部分 */
            foreach ($options AS $key => $val)
            {
                if ($val['level'] >= $end_level)
                {
                    unset($options[$key]);
                }
            }
        }
    
        if ($re_type == true)
        {
            $select = '';
            foreach ($options AS $var)
            {
                $select .= '<option value="' . $var['cat_id'] . '" ';
                $select .= ($selected == $var['cat_id']) ? "selected='ture'" : '';
                $select .= '>';
                if ($var['level'] > 0)
                {
                    $select .= str_repeat('&nbsp;', $var['level'] * 4);
                }
                $select .= htmlspecialchars(addslashes($var['cat_name']), ENT_QUOTES) . '</option>';
            }
    
            return $select;
        }
        else
        {
            foreach ($options AS $key => $value)
            {
                $options[$key]['url'] = build_uri('category', array('cid' => $value['cat_id']), $value['cat_name']);
            }
    
            return $options;
        }
    }
    
    /**
     * 创建像这样的查询: "IN('a','b')";
     *
     * @access   public
     * @param    mix      $item_list      列表数组或字符串
     * @param    string   $field_name     字段名称
     *
     * @return   void
     */
    function db_create_in($item_list, $field_name = '')
    {
        if (empty($item_list))
        {
            return $field_name . " IN ('') ";
        }
        else
        {
            if (!is_array($item_list))
            {
                $item_list = explode(',', $item_list);
            }
            $item_list = array_unique($item_list);
            $item_list_tmp = '';
            foreach ($item_list AS $item)
            {
                if ($item !== '')
                {
                    $item_list_tmp .= $item_list_tmp ? ",'$item'" : "'$item'";
                }
            }
            if (empty($item_list_tmp))
            {
                return $field_name . " IN ('') ";
            }
            else
            {
                return $field_name . ' IN (' . $item_list_tmp . ') ';
            }
        }
    }
    
    /**
     * 获得所有扩展分类属于指定分类的所有商品ID
     *
     * @access  public
     * @param   string $cat_id     分类查询字符串
     * @return  string
     */
    function getExtensionItem($cats)
    {
        $itemCat = 'item_cat';
        $extension_goods_array = '';
        $sql = 'SELECT item_id FROM ' . $itemCat . " AS g WHERE $cats";
        $extension_goods_array = DB::select($sql);
        return $this->db_create_in($extension_goods_array, 'g.id');
    }
    
    /**
     * 获得分类的信息
     *
     * @param   integer $cat_id
     *
     * @return  void
     */
    function getCatInfo($cat_id = 1)
    {
        $category = 'category';
        $rs = DB::select('SELECT cat_name, keywords, cat_desc, style, grade, filter_attr, parent_id FROM ' . $category .
            " WHERE cat_id = '$cat_id'");
        var_dump($rs);exit;
    }
    
    /* 属性筛选 */
    function filterAttrList($attr){

        
        $attribute = 'attribute';
        $itemAttr = 'item_attr';
        $item = 'item';
        
        $children = $this->getChildren(1);
        //var_dump($children);exit;
        $ext = ''; //商品查询条件扩展
        if ($attr > 0)
        {
            $cat_filter_attr = explode(',', $filter_attr);       //提取出此分类的筛选属性
            $all_attr_list = array();
  
            foreach ($cat_filter_attr AS $key => $value)
            {
                $sql = "SELECT a.attr_name FROM " . $attribute . " AS a, " . $itemAttr . " AS ga, " . $item . " AS g WHERE ($children OR " . $this->getExtensionItem($children) . ") AND a.attr_id = ga.item_id AND g.id = ga.item_id  AND a.attr_id='$value'";
              //  echo $sql;exit;
                if($temp_name = DB::select($sql))
                {
                    $all_attr_list[$key]['filter_attr_name'] = $temp_name;
        
                    $sql = "SELECT a.attr_id, MIN(a.item_attr_id ) AS item_id, a.attr_value AS attr_value FROM " . $itemAttr . " AS a, " . $item.
                    " AS g" .
                    " WHERE ($children OR " . $this->getExtensionItem($children) . ') AND g.id = a.item_id AND  '.
                    " AND a.attr_id='$value' ".
                    " GROUP BY a.attr_value";
        
                    $attr_list = $db->getAll($sql);
        
                    $temp_arrt_url_arr = array();
        
                    for ($i = 0; $i < count($cat_filter_attr); $i++)        //获取当前url中已选择属性的值，并保留在数组中
                    {
                        $temp_arrt_url_arr[$i] = !empty($filter_attr[$i]) ? $filter_attr[$i] : 0;
                    }
        
                    $temp_arrt_url_arr[$key] = 0;                           //“全部”的信息生成
                    $temp_arrt_url = implode('.', $temp_arrt_url_arr);
                    $all_attr_list[$key]['attr_list'][0]['attr_value'] = $_LANG['all_attribute'];
                    $all_attr_list[$key]['attr_list'][0]['url'] = build_uri('category', array('cid'=>$cat_id, 'bid'=>$brand, 'price_min'=>$price_min, 'price_max'=>$price_max, 'filter_attr'=>$temp_arrt_url), $cat['cat_name']);
                    $all_attr_list[$key]['attr_list'][0]['selected'] = empty($filter_attr[$key]) ? 1 : 0;
        
                    foreach ($attr_list as $k => $v)
                    {
                        $temp_key = $k + 1;
                        $temp_arrt_url_arr[$key] = $v['goods_id'];       //为url中代表当前筛选属性的位置变量赋值,并生成以‘.’分隔的筛选属性字符串
                        $temp_arrt_url = implode('.', $temp_arrt_url_arr);
        
                        $all_attr_list[$key]['attr_list'][$temp_key]['attr_value'] = $v['attr_value'];
                        $all_attr_list[$key]['attr_list'][$temp_key]['url'] = build_uri('category', array('cid'=>$cat_id, 'bid'=>$brand, 'price_min'=>$price_min, 'price_max'=>$price_max, 'filter_attr'=>$temp_arrt_url), $cat['cat_name']);
        
                        if (!empty($filter_attr[$key]) AND $filter_attr[$key] == $v['goods_id'])
                        {
                            $all_attr_list[$key]['attr_list'][$temp_key]['selected'] = 1;
                        }
                        else
                        {
                            $all_attr_list[$key]['attr_list'][$temp_key]['selected'] = 0;
                        }
                    }
                }
        
            }
            
            $filter_attr_list = $all_attr_list;
          //  $smarty->assign('filter_attr_list',  $all_attr_list);
           
        }
        
        
    }
    
    
    
    /**
     * 获得分类下的商品
     *
     * @access  public
     * @param   string  $children
     * @return  array
     */
    function categoryGetItem($ext)
    {
       // $where = " ($children OR " . $this->getExtensionItem($children) . ')';
         $where = '1=1';
    $item = 'item';
        /* 获得商品列表 */
        $sql = 'SELECT g.id, g.name FROM item AS g '.
           
            "WHERE $where $ext";
       // echo $sql;exit;
   
        $row = DB::select($sql);
       // var_dump($row);
        return $row;
    }
}