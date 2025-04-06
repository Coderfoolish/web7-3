<div id="chuky-content" class="container h-full">
    <div class="flex items-center justify-between mb-4">
        <h1>Quản lý chu kỳ</h1>
        <div class="flex items-center gap-4">
            <!-- <button type="button" class="action-item btn btn-primary" data-act="ks-tao"
                data-aria-haspopup="dialog" aria-expanded="false"
                aria-controls="create-ks-modal" data-overlay="#create-ks-modal">Tạo bài khảo sát</button> -->
            <button class="action-item btn btn-primary" data-act="chuky-them">Thêm chu kỳ</button>
        </div>
    </div>
    <div class="flex items-center justify-between mb-4">
        <div class="flex items-center gap-4">
            <div>
                <label class="label-text" for="select-status">Status </label>
                <select class="select" id="select-status">
                    <option value="-1">Chọn status</option>
                </select>
            </div>
            <button class="btn btn-primary" data-act="chuky-loc">Lọc</button>
        </div>
    </div>

    <div class="w-full overflow-x-auto">
        <table class="table">
            <thead>
                <tr>
                    <th>Mã Chu kỳ</th>
                    <th>Chu kỳ</th>
                    <th>Trạng thái</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="chuky-list">
                <tr>
                    <td>1</td>
                    <td>2020-2024</td>
                    <td>1</td>
                    <td>
                        <button class="action-item btn btn-primary" data-act="chuky-sua">Sửa</button>
                        <button class="btn btn-primary" data-act="chuky-khoa">Khóa</button>
                    </td>
                </tr>

            </tbody>
        </table>
    </div>
</div>
<script src="../node_modules/flyonui/flyonui.js"></script>
<script src="./views/javascript/chuky.js"></script>