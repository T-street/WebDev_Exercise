<?php

/*
 * @author Twayne Street
 */
class search {

    public function query() {
        $search_query = $this->input->post('search');
        $result = $this->get_result($search_query);
        $response = array();

        if ($result->count > 0) {
            $response['status'] = "OK";
            $response['results'] = $this->format_result($result);
        } else {

            $response['status'] = "result_empty";
        }

        echo json_encode($response);
    }

    public function format_result($rawresults) {

        $list = array();
        foreach ($rawresults->blocklist as $item) {

            $info = array('title' => $item->title, 'my_short_url' => $item->my_short_url, 'synopsis' => $item->synopsis, 'availability' => $item->availability);

            if (!(array_key_exists($item->toplevel_container_title, $list))) {
                $list[$item->toplevel_container_title] = array();
            }

            array_push($list[$item->toplevel_container_title], $info);
        }
        
        return $this->html($list);
    }

    public function html($list) {
        $html = "";

        foreach ($list as $featured => $items) {
            $html .= "<ul class=\"brand_info\">";
            $html .= "<li><span class=\"brand_title\">$featured</span>";

            $html .= "<ul class=\"sub_info\">";
            foreach ($items as $item) {

                $html .= "<li><a href=\"http://" . $item["my_short_url"] . "\" target=\"_blank\"  title=\"" . $item["availability"] . "\">" . $item["title"] . "</a><p>" . $item["synopsis"] . "\"</li>";
            }

            $html.="</ul>";
            $html.= "</li>";
            $html.="</ul>";
        }
        $html.="</ul>";
        return $html;
    }

    public function get_result($search_query) {
        $search = urlencode($search_query);
        $url = "http://www.bbc.co.uk/iplayer/ion/searchextended/search_availability/iplayer/service_type/radio/format/json/q/$search";
        $data = file_get_contents($url);
        $data = json_decode($data);
        return $data;
    }

}
?>
