<?php
 
class ControllerCategory
{ 
    private $db;
    private $pdo;
    function __construct() 
    {
        // connecting to database
        $this->db = new DB_Connect();
        $this->pdo = $this->db->connect();
    }
 
    function __destruct() { }

    public function updateCategoryPID($pid) {
        $stmt = $this->pdo->prepare('UPDATE tbl_storefinder_categories SET pid = 0 WHERE pid = :pid');
        $result = $stmt->execute( array('pid' => $pid) );
        return $result ? true : false;
    }
 
    public function updateCategory($itm) {
        $stmt = $this->pdo->prepare('UPDATE tbl_storefinder_categories 
                                        SET category = :category,
                                            category_icon =  :category_icon,
                                            map_icon =  :map_icon,
                                            updated_at = :updated_at,
                                            pid = :pid 
                                        WHERE category_id = :category_id');

        $result = $stmt->execute(
                            array('category' => $itm->category, 
                                    'category_icon' => $itm->category_icon, 
                                    'map_icon' => $itm->map_icon, 
                                    'updated_at' => $itm->updated_at, 
                                    'pid' => $itm->pid, 
                                    'category_id' => $itm->category_id) );
        
        return $result ? true : false;
    }

    public function deleteCategory($category_id, $is_deleted) {
        $stmt = $this->pdo->prepare('UPDATE tbl_storefinder_categories SET is_deleted = :is_deleted AND pid = -1 WHERE category_id = :category_id');
        $result = $stmt->execute( array('is_deleted' => $is_deleted, 'category_id' => $category_id) );
        return $result ? true : false;
    }

    public function insertCategory($itm) {
        $stmt = $this->pdo->prepare('INSERT INTO tbl_storefinder_categories( 
                                            category,
                                            category_icon,
                                            map_icon,
                                            created_at,
                                            updated_at,
                                            is_deleted,
                                            pid ) 
                                        VALUES( 
                                            :category,
                                            :category_icon,
                                            :map_icon,
                                            :created_at,
                                            :updated_at,
                                            0,
                                            :pid )');
        
        $result = $stmt->execute(
                            array('category' => $itm->category,
                                    'category_icon' => $itm->category_icon,
                                    'map_icon' => $itm->map_icon,
                                    'created_at' => $itm->created_at,
                                    'pid' => $itm->pid, 
                                    'updated_at' => $itm->updated_at ) );
        
        return $result ? true : false;
    }

    public function formatRow($row) {
        $itm = new Category();
        $itm->category_id = $row['category_id'];
        $itm->category = $row['category'];
        $itm->category_icon = $row['category_icon'];
        $itm->map_icon = $row['map_icon'];
        $itm->created_at = $row['created_at'];
        $itm->updated_at = $row['updated_at'];
        $itm->is_deleted = $row['is_deleted'];
        $itm->pid = $row['pid'];
        return $itm;
    }
 
    public function getCategories() {
        $stmt = $this->pdo->prepare('SELECT * FROM tbl_storefinder_categories WHERE is_deleted = 0 ORDER BY category ASC');
        $stmt->execute();
        $array = array();
        $ind = 0;
        foreach ($stmt as $row) {
            // do something with $row
            $itm = $this->formatRow($row);
            $array[$ind] = $itm;
            $ind++;
        }
        return $array;
    }

    public function getCategoriesBySearching($search) {
        $stmt = $this->pdo->prepare('SELECT * FROM tbl_storefinder_categories WHERE is_deleted = 0 AND category LIKE :search ORDER BY category ASC');
        $stmt->execute( array('search' => '%'.$search.'%'));
        $array = array();
        $ind = 0;
        foreach ($stmt as $row) {
            // do something with $row
            $itm = $this->formatRow($row);
            $array[$ind] = $itm;
            $ind++;
        }
        return $array;
    }


    public function getCategoryByCategoryId($category_id) {
        $stmt = $this->pdo->prepare('SELECT * FROM tbl_storefinder_categories WHERE category_id = :category_id');
        $stmt->execute( array('category_id' => $category_id));
        $array = array();
        $ind = 0;
        foreach ($stmt as $row) {
            // do something with $row
            $itm = $this->formatRow($row);
            return $itm;
        }
        return null;
    }


    public function getCategoriesByCategory($category) {
        $stmt = $this->pdo->prepare('SELECT * FROM tbl_storefinder_categories WHERE category = :category');
        $stmt->execute( array('category' => $category));
        $array = array();
        $ind = 0;
        foreach ($stmt as $row) {
            // do something with $row
            $itm = $this->formatRow($row);
            return $itm;
        }
        return null;
    }

    public function getCategoriesAtRange($begin, $end) {
        $stmt = $this->pdo->prepare('SELECT * FROM tbl_storefinder_categories WHERE is_deleted = 0 ORDER BY category_id ASC LIMIT :beg, :end');
        $stmt->execute( array('beg' => $begin, 'end' => $end) );
        $array = array();
        $ind = 0;
        foreach ($stmt as $row) {
            $itm = $this->formatRow($row);
            $array[$ind] = $itm;
            $ind++;
        } 
        return $array;
    }

    public function getCategoriesByPID($category_id) {
        $stmt = $this->pdo->prepare('SELECT * FROM tbl_storefinder_categories WHERE pid = :category_id AND is_deleted = 0 ORDER BY category ASC');
        $stmt->execute( array('category_id' => $category_id));
        $array = array();
        $ind = 0;
        foreach ($stmt as $row) {
            // do something with $row
            $itm = $this->formatRow($row);
            $array[$ind] = $itm;
            $ind++;
        }
        return $array;
    }

    public function getCategoriesLeafNode() {
        $stmt = $this->pdo->prepare('SELECT 
                                        t1.category_id,
                                        t1.category,
                                        t1.created_at,
                                        t1.updated_at,
                                        t1.is_deleted,
                                        t1.pid 
                                    FROM tbl_storefinder_categories AS t1 LEFT JOIN tbl_storefinder_categories as t2
                                    ON t1.category_id = t2.pid
                                    WHERE t2.category_id IS NULL AND t1.is_deleted = 0 AND t1.pid >= 0 ORDER BY t1.category ASC');

        $stmt->execute();

        $array = array();
        $ind = 0;
        foreach ($stmt as $row) {
            // do something with $row
            $itm = $this->formatRow($row);
            $array[$ind] = $itm;
            $ind++;
        }
        return $array;
    }

    public function getCategoriesResultSearch($search) {
        $refs = array();
        $list = array();
        $stmt = $this->pdo->prepare('SELECT * FROM tbl_storefinder_categories WHERE is_deleted = 0 AND category LIKE :search ORDER BY category ASC');
        $stmt->execute( array('search' => '%'.$search.'%'));
        foreach ($stmt as $row) {
            $ref = & $refs[$row['category_id']];
            $ref['pid'] = $row['pid'];
            $ref['category']      = $row['category'];
            $ref['category_id']      = $row['category_id'];
            $ref['category_icon']      = $row['category_icon'];
            $ref['map_icon']      = $row['map_icon'];
            if ($row['pid'] == 0) {
                $list[$row['category_id']] = & $ref;
            }
            else {
                $refs[$row['pid']]['children'][$row['category_id']] = & $ref;
            }
        }

        return $list;
    }

    public function getCategoriesResult() {
        $refs = array();
        $list = array();
        $stmt = $this->pdo->prepare('SELECT * FROM tbl_storefinder_categories WHERE is_deleted = 0 ORDER BY category ASC');
        $stmt->execute();
        foreach ($stmt as $row) {
            $ref = & $refs[$row['category_id']];
            $ref['pid'] = $row['pid'];
            $ref['category']      = $row['category'];
            $ref['category_id']      = $row['category_id'];
            $ref['category_icon']      = $row['category_icon'];
            $ref['map_icon']      = $row['map_icon'];
            if ($row['pid'] == 0) {
                $list[$row['category_id']] = & $ref;
            }
            else {
                $refs[$row['pid']]['children'][$row['category_id']] = & $ref;
            }
        }
        return $list;
    }

}
 
?>