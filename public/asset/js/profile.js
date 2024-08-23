document.addEventListener("DOMContentLoaded", function() {
    const uploadInput = document.getElementById("uploadInput");
    const editBtn = document.getElementById("btnEdit");
    const saveBtn = document.getElementById("btnSave");
    const uploadBtn = document.getElementById("btnUploadAvatar");
    const formInputs = document.querySelectorAll(".form-input");


    uploadInput.style.display = "none";

    // Khi click vào nút "Thay đổi ảnh đại diện"
    btnUploadAvatar.addEventListener("click", function() {
        uploadInput.click(); // Mở hộp thoại chọn file
    });

    // Khi người dùng chọn file
    uploadInput.addEventListener("change", function() {
        this.form.submit(); // Submit form tự động khi có file được chọn
    });

    // Disable tất cả input khi trang được load
    formInputs.forEach(input => input.disabled = true);

    // Khi click vào nút Edit
    editBtn.addEventListener("click", function() {
        editBtn.style.display = "none";
        saveBtn.style.display = "flex";
        uploadBtn.style.display = "flex";

        // Bật tất cả các input có class form-input
        formInputs.forEach(input => {
                if (input.id !== "maGV") {  // Giả sử ID của input Mã giảng viên là "maGiangVien"
                    input.style.borderColor = "#ccc"; // hoặc áp dụng các thay đổi khác
                    input.disabled = false; // Hoặc bật input để có thể chỉnh sửa
                }
                input.style.borderColor = "#ccc"; // hoặc áp dụng các thay đổi khác
            }
        );
    });

    // Khi click vào nút Save
    saveBtn.addEventListener("click", function() {
        saveBtn.style.display = "none";
        uploadBtn.style.display = "none";
        editBtn.style.display = "flex";

        // Disable lại tất cả các input
        formInputs.forEach(input => input.disabled = true);
    });
});