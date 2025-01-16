<?= $this->include('user/header') ?>
<?= $this->include('alert') ?>
<style>
iframe {
    width: 100%;
    height: 400px;
    border-radius: 10px;
}

@media only screen and (max-width: 768px) {
    iframe {
        height: 158px;
    }
}

.course-li {
    list-style: none;
    margin-left: -25px;
    border: 1px solid gray;
    border-radius: 5px;
    margin-bottom: 8px;
    padding: 5px;
}

.pagination {
    display: flex;
    justify-content: space-between;
    margin-top: 10px;
}

.pagination a {
    padding: 5px 12px;
    text-decoration: none;
    border: 1px solid gray;
    border-radius: 5px;
    color: black;
}

.pagination a.disabled {
    pointer-events: none;
    color: gray;
}
</style>

<main class="nxl-container">
    <div class="nxl-content">
        <div class="main-content">
            <div class="row">
                <div class="col-12 col-lg-6 d-flex">
                    <div class="card rounded-4 w-100">
                        <div class="card-body p-0">
                            <div class="p-3 rounded">
                                <h6 class="mb-0 text-uppercase">Course Video</h6>
                                <hr>
                                <?php if (!empty($selectedVideoLink)) { ?>
                                <iframe height="315"
                                    src="https://www.youtube.com/embed/<?= parse_url($selectedVideoLink['link'], PHP_URL_PATH); ?>"
                                    title="YouTube video player" frameborder="0"
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                    referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                                <?php
                                } else {
                                    echo '<h6 class="text-danger">No Video Available!</h6>'; 
                                } ?>
                                <?php if($watchedCourse) { ?>
                                <a href="quiz?course=<?= $course['id'] ?>" class="btn btn-success mt-3 w-100">Get
                                    Certificate</a>
                                <?php } else if(!empty($selectedVideoLink)) { ?>
                                <form action="<?= base_url('user/mark-course-complete') ?>" method="POST">
                                    <input type="hidden" name="mark_complete">
                                    <input type="hidden" name="course_id" value="<?= $course['id'] ?>">
                                    <input type="hidden" name="course_name" value="<?= $course['name'] ?>">
                                    <button type="submit" class="btn btn-primary mt-3 w-100">Mark As Complete</button>
                                </form>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-lg-6 d-flex">
                    <div class="card rounded-4 w-100">
                        <div class="card-body p-0">
                            <div class="p-3 rounded">
                                <h6 class="mb-0 text-uppercase">Course Lessons</h6>
                                <hr>
                                <?php if (!empty($videoLinks)) { ?>
                                <ul style="padding-left: 2em;">
                                    <?php 
                                        foreach ($videoLinks as $videoLink): ?>
                                    <a href="<?= base_url('user/course-view?course=' . $course['id'] . '&video=' . $videoLink['id'] . '&page=' . $page) ?>">
                                        <li class="course-li"><?= $videoLink['topic']; ?></li>
                                    </a>
                                    <?php endforeach; ?>
                                </ul>

                                <!-- Pagination -->
                                <div class="pagination">
                                    <?php
                                        $prevPage = ($page > 1) ? $page - 1 : null;
                                        $nextPage = ($page < $totalPages) ? $page + 1 : null;
                                        ?>
                                    <a href="<?= base_url('user/course-view?course=' . $course['id'] . '&page=' . $prevPage) ?>"
                                        class="<?= $prevPage ? '' : 'disabled'; ?>">Prev</a>
                                    <a href="<?= base_url('user/course-view?course=' . $course['id'] . '&page=' . $nextPage) ?>"
                                        class="<?= $nextPage ? '' : 'disabled'; ?>">Next</a>
                                </div>
                                <?php
                                } else {
                                    echo "No course found!";
                                } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<?= $this->include('user/footer') ?>