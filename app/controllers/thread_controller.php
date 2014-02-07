<?php
class ThreadController extends AppController
{
    public function index()
    {
        $rows = Thread::countThreads();
        $page_rows = 3;

        // Last page number
        $last = ceil($rows/$page_rows);
        // Makes sure the last page cannot be less than 1 page
        if ($last < 1) {
            $last = 1;
        }

        // Establish $pagenum variable
        $pagenum = 1;
        // Get pagenum from URL vars if it is present, else it is = 1
        $pn = Param::get('pn');
        if (isset($pn)) {
            $pagenum = preg_replace('#[^0-9]#', '', $pn);
        }

        // Makes sure page number cannot be below 1, or more than the last page numebr
        if ($pagenum < 1) {
            $pagenum = 1;
        } else if ($pagenum > $last) {
            $pagenum = $last;
        }
		
        // Sets the range of rows to query for the chosen $pagenum
        $limit = 'LIMIT ' . ($pagenum - 1) * $page_rows . ',' . $page_rows;
        $threads = Thread::getAll($limit);
        
        // The following controls on pagination
        $paginationCtrls = '';
        if ($last != 1) {
            if ($pagenum > 1) {
                $previous = $pagenum - 1;
                $paginationCtrls .= '<a href="?pn=' . $previous . '">Previous</a> &nbsp; &nbsp; ';

                for ($i = $pagenum-4; $i < $pagenum; $i++) {
                    if ($i > 0) {
                        $paginationCtrls .= '<a href="?pn=' . $i . '">' . $i . '</a> &nbsp; ';
                    }
                }
            }

            $paginationCtrls .= '' . $pagenum . ' &nbsp; ';

            for ($i = $pagenum+1; $i <= $last; $i++) {
                $paginationCtrls .= '<a href="?pn=' . $i . '">' . $i . '</a> &nbsp; ';
                if ($i >= $pagenum+4) {
                    break;
                }
            }
            
            if ($pagenum != $last) {
                $next = $pagenum + 1;
                $paginationCtrls .= ' &nbsp; &nbsp; <a href="?pn=' . $next . '">Next</a> ';
            }
        }
        $this->set(get_defined_vars());
    }

    public function view()
    {
        $thread = Thread::get(Param::get('thread_id'));
        $comments = $thread->getComments();

        $this->set(get_defined_vars());
    }

    public function create()
    {
        $thread = new Thread;
        $comment = new Comment;
        $page = Param::get('page_next', 'create');

        switch ($page) {
        case 'create':
            break;
        case 'create_end':
            $thread->title = Param::get('title');
            $comment->body = Param::get('body');
            try {
                $thread->create($comment);
            } catch (ValidationException $e) {
                $page = 'create';
            }
            break;
        default:
            throw new NotFoundException("{$page} is not found");
            break;
        }

        $this->set(get_defined_vars());
        $this->render($page);
    }

    public function write()
    {
        $thread = Thread::get(Param::get('thread_id'));
        $comment = new Comment;
        $page = Param::get('page_next', 'write');

        switch ($page) {
            case 'write':
                break;
            case 'write_end':
                $comment->body = Param::get('body');
                try {
                    $thread->write($comment);
                } catch (ValidationException $e) {
                    $page = 'write';
                }
                break;
            default:
                throw new NotFoundException("{$page} is not found");
                break;
        }

        $this->set(get_defined_vars());
        $this->render($page);
    }

}
