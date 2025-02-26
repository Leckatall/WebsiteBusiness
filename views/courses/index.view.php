<main class="m-5">
    <label for="selectCourse" hidden>View</label>
    <select id="selectCourse" class="form-select">
        <option>All</option>
        <option>My Courses</option>
        <option>Pending</option>
        <option>Available</option>
    </select>
    <hr>
    <!--    TODO: Images on the cards?-->
    <div id="courseCards" class='row row-cols-3'>
        <!--        --><?php //foreach ($courses as $course): ?>
        <!--            <div class="col mb-4">-->
        <!--                <div class="card h-100 m-1 bg-secondary-subtle border-secondary">-->
        <!--                                    <img src="..." class="card-img-top" alt="Course Image">-->
        <!--                    <h5 class="card-header">--><?php //= $course['name'] ?><!--</h5>-->
        <!--                    <div class="card-body">-->
        <!--                        <p class="card-subtitle">--><?php //= $course['description'] ?><!--</p>-->
        <!--                        <button-->
        <!--                                class="btn btn-success">Apply-->
        <!--                        </button>-->
        <!--                        <div class="card-text"><small class="text-muted">Application pending...</small></div>-->
        <!--                    </div>-->
        <!--                </div>-->
        <!--            </div>-->
        <!--        --><?php //endforeach ?>
    </div>
    <?php use Core\Session;

    if (Session::getRole() > 1) : ?>
        <p class="mt-5">
            <a href="/courses/create" class="btn btn-primary">Add Course</a>
        </p>
    <?php endif ?>
</main>

<script>
    function fetchCourses($filter = 'All') {
        fetch(`/api/courses?filter=${encodeURIComponent($filter)}`)
            .then(response => response.json())
            .then(courses => {
                const container = document.getElementById("courseCards");
                container.innerHTML = "";

                courses.forEach(course => {
                    let card_link = ''
                    if (course['applied'] && course['approved']) {
                        card_link = `<a href="/courses/${course.id}" class="stretched-link"></a>`
                    } else if (course['applied']) {
                        card_link = `<div class="card-text"><small class="text-muted">Application pending...</small></div>`
                    } else {
                        card_link = `<button data-id="${course.id}" class="btn btn-success apply-btn">Apply</button>`
                    }

                    const card = `<div class="col mb-4"><div class="card h-100 m-1 bg-secondary-subtle border-secondary">
                                    <h5 class="card-header">${course.name}</h5>
                                    <div class="card-body">
                                    <p class="card-text">${course.description}</p>
                                    ${card_link}
                                  </div></div></div>`;
                    container.innerHTML += card;
                });
            })
            .catch(error => console.error("Error loading courses:", error));
    }

    $(document).ready(function () {
        fetchCourses();
        // Bind dropdown change to fetchCourses
        $("#selectCourse").change(function () {
            fetchCourses($(this).val());
        });
    });

    $(document).on('click', '.apply-btn', function () {
        $.ajax({
                url: `api/courses/${$(this).data('id')}/users`,
                type: `POST`,
                success: function (response) {
                    fetchCourses($("#selectCourse").val());
                    console.log("approved student", response)
                },
                error: function (xhr, status, error) {
                    console.log("Error:", xhr.error);
                }
            }
        );
    });
</script>


