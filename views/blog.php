<?php require_once "./views/layout/header-white.php"; ?>
<?php
$idPost = isset($_GET['id']) ? strip_tags(trim($_GET['id'])) : '';
$values = $post->selectPost($idPost);
?>
<div class="container mt-5">
    <div class="row mb-5">
        <div class="col-md-10 d-block m-auto blog">
            <h2 class="font-weight-bold mb-1"><?= $values['judul']; ?></h2>
            <hr />
            <div class="mb-3">
                <small>Posted on <strong><em><?= $values['created_at']; ?></em></strong> on Category <strong><em><?= $values['nama']; ?></em></strong></small>
            </div>
            <img src='assets/img/<?= $values['img']; ?>' style="width:100%;" class="mb-3" />
            <p class="text-justify">
                <?= $values['isi']; ?>
            </p>
        </div>
    </div>
    <h2 class="mb-4">Lihat lainnya</h2>
    <hr />
    <div class="row blog">
        <?php
        $post_relationship = $post->postRelated($values['category_id']);
        foreach ($post_relationship as $post_related) :
            if ($post_related['id'] != $values['id']) :
                ?>
        <div class="col-md-6 mb-3">
            <div class="img-thumbnail border-0">
                <div class="row">
                    <div class="col-md-5">
                        <img src="./assets/img/<?= $post_related['img']; ?>" alt="">
                    </div>
                    <div class="col">
                        <h4 class="mb-2 font-weight-bold mt-2"><?= $post_related['judul']; ?></h4>
                        <p><?= substr($post_related['isi'], 0, 25) . "..."; ?></p>
                        <a href="blog&id=<?php echo $post_related['id']; ?>" class="btn btn-primary">Lihat</a>
                    </div>
                </div>
            </div>
        </div>
        <?php
            endif;
        endforeach;
        ?>
    </div>

    <div class="comments mb-5">
        <h2>Comments</h2>
        <?php
        $comment_data = $comments->showComments();
        ?>
        <?php if ($comment_data->num_rows == 0) : ?>
        <p>Belum ada komentar</p>
        <?php else : ?>
        <?php foreach ($comments_data as $comment) : ?>
        <div class="comment mb-5">
            <h4 class="mb-3"><?= $comment['nama_lengkap']; ?></h4>
            <small><em><?= time('H:i:s d-m-Y', $comment['created_at']); ?></em></small>
            <p><?= $comment['body']; ?></p>
        </div>
        <?php endforeach; ?>
        <?php endif; ?>
        <div class="comment-box">
            <?php if (!$cekLogin) : ?>
            <p>You need to <a href='./login'>Login</a> comment</p>
            <?php else : ?>
            <form method="POST" action="">
                <?php
                    if (isset($_POST['kirim'])) :
                        $comments->addComment();
                    endif;
                    ?>
                <div class="form-group">
                    <textarea name="body" id="body" rows="3" cols="120"></textarea>
                    <input type="hidden" name="user_id" value="<?= $_SESSION['user_id']; ?>" />
                    <input type="hidden" name="post_id" value="<?= $values['id']; ?>" />
                </div>
                <div class="form-group">
                    <input type="submit" name="kirim" id="kirim" class="btn btn-primary" />
                </div>
            </form>
            <?php endif; ?>
        </div>
    </div>
</div>