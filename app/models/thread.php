<?php
class Thread extends AppModel
{
    public $validation = array(
        'title' => array(
            'length' => array(
                'validate_between', 1, 30,
            ),
        ),
    );

    public static function get($id)
    {
        $db = DB::conn();
        $row = $db->row('SELECT * FROM thread WHERE id = ?', array($id));
        return new self($row);
    }

    public static function getAll($limit)
    {
        $threads = array();
        
        $db = DB::conn();
        $rows = $db->rows("SELECT * FROM thread {$limit}");
        foreach ($rows as $row) {
            $threads[] = new Thread($row);
        }

        return $threads;
    }

    public static function countThreads()
    {
        $db = DB::conn();
        $rows = $db->value('SELECT COUNT(id) FROM thread');
        return $rows;
    }	

    public function getComments()
    {
        $comments = array();

        $db = DB::conn();
        $rows = $db->rows(
            'SELECT comment.id, thread_id, user.username, body, created FROM comment
            INNER JOIN user ON comment.user_id = user.id
            WHERE thread_id = ? ORDER BY created ASC',
            array($this->id)
        );
        foreach ($rows as $row) {
            $comments[] = new Comment($row);
        }

        return $comments;
    }

    public function create(Comment $comment)
    {
        $this->validate();
        $comment->validate();
        if ($this->hasError() || $comment->hasError()) {
            throw new ValidationException('invalid thread or comment');
        }
        
        $db = DB::conn();
		$db->begin();

        $user_id = $_SESSION['id'];

        $db->query('INSERT INTO thread SET user_id = ?, title = ?, created = NOW()', 
            array($user_id, $this->title)
        );
        $this->id = $db->lastInsertId();

		// write first comment at the same time
        $this->write($comment);

        $db->commit();
    }

    public function write(Comment $comment)
    {
        if (!$comment->validate()) {
            throw new ValidationException('invalid comment');
        }

        $db = DB::conn();
        $user_id = $_SESSION['id'];
        $db->query(
            'INSERT INTO comment SET thread_id = ?, user_id = ?, body = ?, created = NOW()',
            array($this->id, $user_id, $comment->body)
        );
    }	
}
