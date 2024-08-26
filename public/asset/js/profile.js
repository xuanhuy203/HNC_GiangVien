document.addEventListener("DOMContentLoaded", function() {
    const uploadInput = document.getElementById("uploadInput");
    const editBtn = document.getElementById("btnEdit");
    const saveBtn = document.getElementById("btnSave");
    const uploadBtn = document.getElementById("btnUploadAvatar");
    const formInputs = document.querySelectorAll(".form-input");
    const inputViews = document.querySelectorAll(".input-view");
    const selectEdits = document.querySelectorAll(".select-edit");
    const title = document.getElementById('title');

    uploadInput.style.display = "none";

    // Khi click vào nút "Thay đổi ảnh đại diện"
    uploadBtn.addEventListener("click", function() {
        uploadInput.click(); // Mở hộp thoại chọn file
    });

    // Khi người dùng chọn file
    uploadInput.addEventListener("change", function() {
        this.form.submit(); // Submit form tự động khi có file được chọn
    });

    // Disable tất cả input khi trang được load
    formInputs.forEach(input => input.readOnly = true);

    // Khi click vào nút Edit
    editBtn.addEventListener("click", function() {
        // Đổi tiêu đề khi ở chế độ chỉnh sửa
        title.textContent = 'Chỉnh Sửa Thông Tin Giảng Viên';
        editBtn.style.display = "none";
        saveBtn.style.display = "flex";
        uploadBtn.style.display = "flex";

        // Bật tất cả các input có class form-input
        formInputs.forEach(input => {
            if (input.id !== "maGV") { // Giả sử ID của input Mã giảng viên là "maGV"
                input.readOnly = false; // Hoặc bật input để có thể chỉnh sửa
                input.style.borderColor = "#ccc"; // hoặc áp dụng các thay đổi khác
            }
        });

        inputViews.forEach(input => input.style.display = "none");
        selectEdits.forEach(select => select.style.display = "flex");
    });

    // Khi click vào nút Save
    saveBtn.addEventListener("click", function() {
        // Đổi tiêu đề khi ở chế độ chỉnh sửa
        title.textContent = 'Thông Tin Giảng Viên';
        saveBtn.style.display = "none";
        uploadBtn.style.display = "none";
        editBtn.style.display = "flex";

        // Disable lại tất cả các input
        formInputs.forEach(input => input.readOnly = true);

        inputViews.forEach(input => input.style.display = "flex");
        selectEdits.forEach(select => select.style.display = "none");
    });
});