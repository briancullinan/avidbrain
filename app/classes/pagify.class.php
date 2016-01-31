<?php

/**
 * Pagination class
 *
 * @package		default
 * @author 		Seth Baur
 * @license		http://creativecommons.org/licenses/BSD/
 * @version		0.1
 *
 *
 **/
class Pagify{
    /**
     * number of object per page
     *
     * @var int
     */
    private $per_page = 5;

    private $ignoreslash = false;
    private $number_wrap = [];

    /**
     * the total number of items
     *
     * @var int
     **/
    private $total = 0;

    /**
     * the current page
     *
     * @var int
     **/
    private $page = 1;

    /**
     * how many page numbers to show before and after
     * the current page
     *
     * @var int
     **/
    private $range = 4;

    /**
     * the url to link to
     *
     * @var string
     **/
    private $url = '';

    /**
     * show previous and next buttons
     *
     * @var bool
     **/
    private $show_prev_next = TRUE;

    /**
     * show first and last buttons
     *
     * @var bool
     **/
    private $show_first_last = TRUE;

    /**
     * show number links
     *
     * @var bool
     **/
    private $show_numbers = TRUE;

    /**
     * last page number
     *
     * @var int
     **/
    public $last_page_number;

    /**
     * Template variables
     *
     */
    private $separator = ' ';
    private $tag_open = '<ul class="pagination">';
    private $tag_close = '</ul>';
    private $prev_link_text = '<i class="fa fa-chevron-left"></i>';
    private $prev_link_tag_open = '<span id="prev_link">';
    private $prev_link_tag_close = '</span>';
    private $next_link_text = '<i class="fa fa-chevron-right"></i>';
    private $next_link_tag_open = '<span id="next_link">';
    private $next_link_tag_close = '</span>';
    private $first_link_text = '<i class="fa fa-chevron-left"></i><i class="fa fa-chevron-left"></i>';
    private $first_link_tag_open = '<span id="first_link">';
    private $first_link_tag_close = '</span>';
    private $last_link_text = '<i class="fa fa-chevron-right"></i><i class="fa fa-chevron-right"></i>';
    private $last_link_tag_open = '<span id="last_link">';
    private $last_link_tag_close = '</span>';

    // ---------------------------------------------------------------

    /**
     * constructor
     *
     * @access    public
     * @param    void
     * @return    void
     **/
    public function __construct($config = array())
    {
		$this->initialize($config);
    }

    // ---------------------------------------------------------------

    /**
	 * initialize config
	 *
	 * @access	public
	 * @param	array config
	 * @return	void
	 */
	function initialize($config = array())
	{
		foreach ($config as $key => $val)
		{
		    if (method_exists($this, 'set_'.$key)) {
		        $this->{'set_'.$key}($val);
		    }
			else if (isset($this->$key))
			{
				$this->$key = $val;
			}
		}


		$total = (int)(str_replace(',','',$this->total));
		$per_page = ($this->per_page);
		$division = (int)ceil(($total / $per_page));

		$this->last_page_number = $division;
	}

    // ---------------------------------------------------------------

    /**
     * get current links
     *
     * @access    public
     * @param    void
     * @return    string
     **/
    public function get_links()
    {
        if(isset($this->number_wrap) && isset($this->number_wrap[0]) && isset($this->number_wrap[1])){
            $pre = $this->number_wrap[0];
            $post = $this->number_wrap[1];
            $this->number_wrap = (object)['pre'=>$pre,'post'=>$post];
        }
        else{
            $this->number_wrap = (object)['pre'=>'','post'=>''];
        }
        $output = $this->tag_open;
        $links = array();

        if($this->total <= $this->per_page){
	        return null;
        }

        // first and previous page links, if applicable
        if ($this->page > 1) {
            if ($this->show_first_last) {
                $links[] = $this->get_first_link();
            }

            if ($this->show_prev_next) {
                $links[] = $this->get_prev_link();
            }
        }

        if ($this->show_numbers) {
            // number links before current page
            if ($this->page - $this->range > 0) {
                for ($i = $this->page - $this->range; $i < $this->page; $i++) {
                    $links[] = '<li><a data-value="'.$i.'" href="' . $this->url.$this->number_wrap->pre.$i.$this->number_wrap->post. '">' . $i . '</a></li>';
                }
            }
            else {
                for ($i = 1; $i < $this->page; $i++) {
                    $links[] = '<li><a data-value="'.$i.'" href="' . $this->url.$this->number_wrap->pre.$i.$this->number_wrap->post. '">' . $i . '</a></li>';
                }
            }

            // current page

            if(isset($this->page)){
		        $links[] = '<li class="active"><a data-value="'.$this->number_wrap->pre.$i.$this->number_wrap->post.'" href="#">' . $this->page . '</a></li>';
            }


            // number links after current page
            if ($this->page + $this->range <= $this->last_page_number) {
                for ($i = $this->page + 1; $i <= $this->page + $this->range; $i++) {
                    $links[] = '<li><a data-value="'.$i.'" href="' . $this->url.$this->number_wrap->pre.$i.$this->number_wrap->post. '">' . $i . '</a></li>';
                }
            }
            else {
                for ($i = $this->page + 1; $i <= $this->last_page_number; $i++) {
                    $links[] = '<li><a data-value="'.$i.'" href="' . $this->url.$this->number_wrap->pre.$i.$this->number_wrap->post. '">' . $i . '</a></li>';
                }
            }
        }

        // show next and last page link, if applicable
        if ($this->page < $this->last_page_number) {
            if ($this->show_prev_next) {
                $links[] = $this->get_next_link();
            }

            if ($this->show_first_last) {
                $links[] = $this->get_last_link();
            }
        }

        $output .= implode($this->separator, $links);
        $output .= $this->tag_close;
        return $output;
    }

    // ---------------------------------------------------------------

    /**
     * get current offset
     *
     * @access    public
     * @param    void
     * @return    int
     **/
    public function get_offset()
    {
        return ($this->per_page * $this->page) - $this->per_page;
    }

    // ---------------------------------------------------------------

    /**
     * get the first page link
     *
     * @access    public
     * @param    void
     * @return    string
     **/
    public function get_first_link()
    {
        return '<li class="first_last"><a data-value="1" href="'.$this->url.$this->number_wrap->pre.'1'.$this->number_wrap->post.'">'.$this->first_link_text.'</a></li>';
    }

    // ---------------------------------------------------------------

    /**
     * get the last page link
     *
     * @access    public
     * @param    void
     * @return    void
     **/
    public function get_last_link()
    {
        return '<li class="first_last"><a data-value="'.$this->last_page_number.'" href="'.$this->url.$this->number_wrap->pre.$this->last_page_number.$this->number_wrap->post.'">'.$this->last_link_text.'</a></li>';
    }

    // ---------------------------------------------------------------

    /**
     * get the previous page link
     *
     * @access    public
     * @param    void
     * @return    string
     **/
    public function get_prev_link()
    {

        $link = $this->prev_link_tag_open;
        if ($this->page > 1) {
            $prev_page = $this->page - 1;
            $link .= '<li class="prev_next"><a data-value="'.$prev_page.'" href="'.$this->url.$this->number_wrap->pre.$prev_page.$this->number_wrap->post.'">'.$this->prev_link_text.'</a></li>';
        }
        $link .= $this->prev_link_tag_close;
        return $link;
    }

    // ---------------------------------------------------------------

    /**
     * get the next page link
     *
     * @access    public
     * @param    void
     * @return    void
     **/
    public function get_next_link()
    {
        $link = $this->next_link_tag_open;
        if ($this->page < $this->last_page_number) {
            $next_page = $this->page + 1;
            $link .= '<li class="prev_next"><a data-value="'.$next_page.'" href="'.$this->url.$this->number_wrap->pre.$next_page.$this->number_wrap->post.'">'.$this->next_link_text.'</a></li>';
        }
        $link .= $this->next_link_tag_close;
        return $link;
    }

    // ---------------------------------------------------------------

    /**
     * output which items are showing on the page, and how many there are in total
     *
     * @access    public
     * @param    void
     * @return    void
     **/
    public function create_showing()
    {
        $first = $this->get_offset() + 1;
        $last = $first + $this->per_page - 1;
        if ($last > $this->total)
        {
            $last = $this->total;
        }
        return "Showing " . $first . "-" . $last . " of " . $this->total;
    }

    // ---------------------------------------------------------------

    /**
     * make sure url has a trailing /
     *
     * @access    public
     * @param    string
     * @return    void
     **/
    public function set_url($url)
    {
        if($this->ignoreslash == true){

        }
        else{
            if (substr($url,-1) != '/') {
                $url .= '/';
            }

        }

        $this->url = $url;
    }

    // ---------------------------------------------------------------
}
