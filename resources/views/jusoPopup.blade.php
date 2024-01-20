<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Insert title here</title>
    <?php
		$ADDR['inputYn'] = isset($_POST['inputYn']) ? $_POST['inputYn'] : 'N';
		$ADDR['roadAddrPart1'] = isset($_POST['roadAddrPart1']) ? $_POST['roadAddrPart1'] : '';
		$ADDR['addrDetail'] = isset($_POST['addrDetail']) ? $_POST['addrDetail'] : '';
		$ADDR['zipNo'] = isset($_POST['zipNo']) ? $_POST['zipNo'] : '';
	?>
</head>
<script language="javascript">

    function init() {
        var url = location.href;
        var confmKey = "{{ env('JUSO_API_KEY','U01TX0FVVEgyMDIzMDQwMzEzMTMyODExMzY0ODM=') }}";
        var resultType = "4";
        var inputYn = "<?= $ADDR['inputYn'] ?>";
        if (inputYn != "Y") {
            document.form.confmKey.value = confmKey;
            document.form.returnUrl.value = url;
            document.form.resultType.value = resultType;
            document.form.action = "https://business.juso.go.kr/addrlink/addrLinkUrl.do";
            document.form.submit();
        } else {
            let data = {
                zip_code: "<?= isset($ADDR['zipNo']) ? $ADDR['zipNo'] : '' ?>",
                address: "<?= isset($ADDR['roadAddrPart1']) ? $ADDR['roadAddrPart1'] : '' ?>",
                detailed_address: "<?= isset($ADDR['addrDetail']) ? $ADDR['addrDetail'] : '' ?>",
            }
            window.opener.postMessage({ message: data }, '*');
            window.close();
        }
    }
</script>

<body onload="init();">
    <form id="form" name="form" method="post">
        <input type="hidden" id="confmKey" name="confmKey" value="" />
        <input type="hidden" id="returnUrl" name="returnUrl" value="" />
        <input type="hidden" id="resultType" name="resultType" value="" />
        {{-- <input type="hidden" id="encodingType" name="encodingType" value="EUC-KR" /> --}}
    </form>
</body>

</html>