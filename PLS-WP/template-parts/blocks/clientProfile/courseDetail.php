<?php
  $post_id = get_the_ID();
  $subscription = get_fields(get_the_ID());
  $details = get_curriculum($post_id);

?>
<div class="flex bg-bgGray h-full">

  <div class="w-full m-10 h-full bg-white border-borderGray border-2 rounded-xl py-3 px-4">
        
    <script>
      const dataArray = [];
      const curriculumData = <?php echo json_encode($details); ?>;
      const lessons = curriculumData['lessons'];
      const lesson_categories = curriculumData['lesson_categories'];
      // console.log('lesson cats:', lesson_categories);
      // console.log('lessons: ', lessons);
      
      // console.log('courseCategories: ', courseCategories);

      for (const key of Object.keys(lessons)) {
        const data = [];
        data.push(lessons[key].post_title);

        // Get lesson categories
        const categories = lesson_categories[key]|| []; // Replace 'categories' with the correct property name
        console.log('the lesson categories',categories);
        // Map category IDs to category names
        const categoriesString = categories.map(category => {

          return category ? category.name : '';
        }).join(', ');

        data.push(categoriesString);
        dataArray.push(data);
      }

      console.log('here it is', dataArray);

      document.addEventListener('DOMContentLoaded', function () {
        new gridjs.Grid({
          sort: true,
          search: true,
          pagination: true,
          columns: [
            {
              name: "Lesson Name",
              attributes: (cell) => {
                if (cell) {
                  return {
                    // onClick: () => {
                    //    alert('clicked');
                    // },
                    'style': 'cursor: pointer',
                  };
                }
              },
            },
            "Category",
            "State Approved",
            "Approved",
          ],
          data: dataArray,
        }).render(document.getElementById("my-grid"));
      });
    </script>

    <div id="my-grid"></div>
  </div>
</div>