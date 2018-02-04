$(document).ready(function() {
	//修改信息验证
	$("#modifyBtn").click(function() {
		var passwordR = $("#passwordR").val();
		var rpasswordR = $("#rpasswordR").val();
		var mottoR = $("#mottoR").val();
		var nicknameR = $("#nicknameR").val();

		//邮箱的正则表达式
		var regEmail = /^([a-zA-Z0-9]+[_|\-|\.]?)*[a-zA-Z0-9]+@([a-zA-Z0-9]+[_|\-|\.]?)*[a-zA-Z0-9]+(\.[a-zA-Z]{2,3})+$/;

		

		//密码检验
		if(passwordR.length > 20) {
			$("#passwordR").focus().css("border", "2px solid #C4473D").parent().next().css({
				"color": "#CB1B45",
			}).text("(密码太长啦~不要超过20位)");
			return false;
		} else if(passwordR != rpasswordR) {
			$("#rpasswordR").focus().css("border", "2px solid #C4473D").parent().next().css({
				"color": "#CB1B45",
			}).text("(第二次竟然输入了不一样的东西~)");
			return false;
		} else {
			$("#passwordR").css("border", "1px solid #CCCCCC").parent().next().css({
				"color": "#000000",
			}).text("(可以咯~)");
		}
		//签名检验
		if(mottoR.length > 200) {
			$("#nicknameR").focus().css("border", "2px solid #C4473D").parent().next().css({
				"color": "#CB1B45",
			}).text("(不要超过200字符哟)");
			return false;
		} else {
			$("#mottoR").css("border", "1px solid #CCCCCC").parent().next().css({
				"color": "#000000",
			}).text("(格式正确了)");
		}
		//昵称检验
		if(nicknameR.length < 6 || nicknameR.length > 20) {
			$("#nicknameR").focus().css("border", "2px solid #C4473D").parent().next().css({
				"color": "#CB1B45",
			}).text("(平时好好学数学啦~是6-20位)");
			return false;
		} else {
			$("#nicknameR").css("border", "1px solid #CCCCCC").parent().next().css({
				"color": "#000000",
			}).text("(格式正确了)");
		}
		
		//邮箱检验
		if(!regEmail.test(emailR)) {
			$("#emailR").focus().css("border", "2px solid #C4473D").parent().next().css({
				"color": "#CB1B45",
			}).text("(格式错啦~)");
			return false;
		} else {
			$("#emailR").css("border", "1px solid #CCCCCC").parent().next().css({
				"color": "#000000",
			}).text("(邮箱正确咯~)");
		}

		$("#modify-form").submit();
	})
	
});