$("input[name='selection[]']").change(function () {
    // checkbox 选择事件
    checkIsShowSelectAllMatch();
});
// 检测是否显示选择全部符合条件提示框以及导出按钮
function checkIsShowSelectAllMatch() {
    const checkedCount = $("input[name='selection[]']:checked").length
    selectAllMatch = false;
    $('#exportsupplierform-exportallmatch').val(0)
    $('#alert-select-all-item-cancel').css('display', 'none');
    $('#alert-select-all-item').css('display', 'none');
    $('#exportBtn').css('display', 'none');
    if (checkedCount <= 0) {
        return;
    }
    let keys = $('#supplier').yiiGridView('getSelectedRows');
    // 如果选择数量和整页数量一致，显示选择全部符合条件提示框
    if (keys.length === 50 && totalCount > 50) {
        $('#alert-select-all-item').css('display', 'block');
    }
    // 如果选择了项目，显示导出按钮
    if (keys.length > 0) {
        $('#exportBtn').css('display', 'block');
        // 设置 model 隐藏字段
        $('#exportsupplierform-ids').val(keys.join(','))
    } else {
        $('#exportsupplierform-ids').val('')
    }
}
// 是否选择全部符合条件项目标识符
let selectAllMatch = false;
// 选择全部符合条件项目按钮
$('#selectAllMathBtn').click(function (e) {
    e.preventDefault();
    selectAllMatch = true;
    $('#exportsupplierform-exportallmatch').val(1)
    $('#alert-select-all-item').css('display', 'none');
    $('#alert-select-all-item-cancel').css('display', 'block');
})
// 清除选择全部符合条件按钮
$('#cancelSelectAllMathBtn').click(function (e) {
    e.preventDefault();
    checkIsShowSelectAllMatch();
})

