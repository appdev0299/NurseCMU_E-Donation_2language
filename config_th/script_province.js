$(function(){
    var provinceObject = $('#province');
    var amphureObject = $('#amphure');
    var districtObject = $('#district');

    // เมื่อโหลดหน้าเว็บใหม่ ให้ดึงข้อมูลของจังหวัดแรกทันที
    provinceObject.trigger('change');

    // เมื่อมีการเลือกจังหวัด
    provinceObject.on('change', function(){
        var provinceId = $(this).val();

        amphureObject.html('<option value="">เลือกอำเภอ</option>');
        districtObject.html('<option value="">เลือกตำบล</option>');

        // ส่งคำขอ Ajax เพื่อดึงข้อมูลอำเภอที่เกี่ยวข้องกับจังหวัดที่เลือก
        $.get('config_th/get_amphure.php?province_id=' + provinceId, function(data){
            var result = JSON.parse(data);
            $.each(result, function(index, item){
                var amphureName = lang === 'en' ? item.name_en : item.name_th;
                amphureObject.append(
                    $('<option></option>').val(item.id).html(amphureName)
                );
            });
        });
    });

    // เมื่อมีการเลือกอำเภอ
    amphureObject.on('change', function(){
        var amphureId = $(this).val();

        districtObject.html('<option value="">เลือกตำบล</option>');
        
        // ส่งคำขอ Ajax เพื่อดึงข้อมูลตำบลที่เกี่ยวข้องกับอำเภอที่เลือก
        $.get('config_th/get_district.php?amphure_id=' + amphureId, function(data){
            var result = JSON.parse(data);
            $.each(result, function(index, item){
                var districtName = lang === 'en' ? item.name_en : item.name_th;
                districtObject.append(
                    $('<option></option>').val(item.id).html(districtName)
                );
            });
        });
    });
});
