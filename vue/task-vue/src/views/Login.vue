//로그인페이지
<template>
    <div>
        <img alt="Vue logo" src="@/assets/logo.png">
        <h1>로그인</h1>
        <!-- 로그인 양식 -->
        <form @submit.prevent="login">
            <div>
                <label for="userId">아이디:</label>
                <input id="userId" v-model="userId">
            </div>
            <div>
                <label for="password">패스워드:</label>
                <input type="password" id="password" v-model="password"/>
            </div>
            <button type="submit">로그인</button>
            <button @click="goToRegister">회원가입</button>
        </form>
        <div v-if="errorMessage" class="error">{{ errorMessage }}</div>
    </div>    
</template>

<script>
import api from "@/utils/api.js";

export default {
    name: "UserLogin",
    data() {
        return{
            userId: "",
            password: "",
            errorMessage: "",
        };
    },
    methods: {
        // 회원가입 페이지로 이동
        goToRegister() {
            this.$router.push({ name: "Register" });
        },
        // 로그인을 시도하고, 성공하면 메인 페이지로 이동
        async login() {
        try {
            const response = await api.post("/login", {
                userId: this.userId,
                password: this.password,
            });

            const token = response.data.token;
            const username = response.data.username;
            const userId = response.data.userId;
            console.log("서버응답 :", response); //서버 응답 출력
            console.log(response.data, "뭐가 넘어오니")
            console.log("Received token:", token);
            console.log("username:", username);
            // access_token을 저장
            localStorage.setItem("user-token", token);
            localStorage.setItem("username", username);
            localStorage.setItem("userId", userId); 
            console.log(userId , "유저아이디");
            // 로그인 성공하면
            this.$router.push({ name: "Posts" });
        } catch (error) {
            console.error(error);
            this.errorMessage="로그인에 실패하였습니다. 아이디 / 비밀번호 확인해주세요";
        }
        },
  },
};
</script>
