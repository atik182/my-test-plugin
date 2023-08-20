<?php

global $wpdb;
$student_table = $wpdb->prefix . 'student_list';
$students = $wpdb->get_results("SELECT * FROM {$student_table} ");

$teacher_table = $wpdb->prefix . 'teacher_list';
$teachers = $wpdb->get_results("SELECT * FROM {$teacher_table} ");

?>



<h2>Welcome </h2>
<p>Welcome to our plugin home </p>


<div class="row">
	<div class="col-lg-6">
		<h1 class="text-center fw-bold mb-5">Student List</h1>
		<form id="myForm">
			<input type="hidden" name="action" value="stored-value" />
			<label>Name
				<input type="text" name="name" value="" id="name" />
			</label>

			<label>Class
				<input type="text" name="class" value="" id="class" />
			</label>

			<label>Age
				<input type="text" name="age" value="" id="age" />
			</label>

			<input type="submit" name="submit" value="Save" />

		</form>

		<table class="table table-striped mt-5">
			<thead>
				<tr>
					<th scope="col">#ID</th>
					<th scope="col">Name</th>
					<th scope="col">Class</th>
					<th scope="col">Age</th>
				</tr>
			</thead>
			<tbody class="itemRow">
				<?php foreach ($students as $student) { ?>
				<tr>
					<th scope="row"><?php echo $student->id; ?></th>
					<td><?php echo $student->name; ?></td>
					<td><?php echo $student->class; ?></td>
					<td><?php echo $student->age; ?></td>
				</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
	<div class="col-lg-6">
		<h1 class="text-center fw-bold mb-5">Teacher List</h1>
		<form id="teacherForm">
			<input type="hidden" name="action" value="stored-value-teacher" />
			<label>Name
				<input type="text" name="name" value="" id="name" />
			</label>

			<label>Department
				<input type="text" name="department" value="" id="department" />
			</label>

			<label>Age
				<input type="text" name="age" value="" id="age" />
			</label>

			<input type="submit" name="submit" value="Save" />

		</form>

		<table class="table table-striped mt-5">
			<thead>
				<tr>
					<th scope="col">#ID</th>
					<th scope="col">Name</th>
					<th scope="col">Department</th>
					<th scope="col">Age</th>
				</tr>
			</thead>
			<tbody class="tableRow">
				<?php foreach ($teachers as $teacher) { ?>
				<tr>
					<th scope="row"><?php echo $teacher->id; ?></th>
					<td><?php echo $teacher->name; ?></td>
					<td><?php echo $teacher->department; ?></td>
					<td><?php echo $teacher->age; ?></td>
				</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
</div>

