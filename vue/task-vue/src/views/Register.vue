//회원가입페이지
<template>
    <div>
        <h1>회원가입</h1>
        <form @submit.prevent="register">
            <!-- 입력한 정보를 받아오는 input 필드들 -->
            <div>
                <label for="userId">아이디:</label>
                <input type="text" id="userId" v-model="userId" required />
            </div>
            <div>
                <label for="username">이름:</label>
                <input type="text" id="username" v-model="username" required />
            </div>
            <div>
                <label for="email">이메일:</label>
                <input type="email" id="email" v-model="email" required />
            </div>
            <div>
                <label for="password">비밀번호:</label>
                <input type="password" id="password" v-model="password" required />
            </div>
            <div>
                <label for="password_confirmation">비밀번호확인:</label>
                <input type="password" id="password_confirmation" v-model="password_confirmation" required />
            </div>
            <!-- 회원가입 버튼 -->
            <button type="submit">회원가입</button>
            <button @click="goToBack">뒤로가기</button>
        </form>
    </div>
</template>

<script>
import axios from "axios";

export default {
    name: "UserRegister",
    data() {
        return {
            userId: "",
            username: "",
            email: "",
            password: "",
            password_confirmation: "",
        };
    },
    methods: {
        // 뒤로 가기 함수 - 로그인 페이지로 이동
        goToBack() {
            this.$router.push({ name: "Login" });
        },
        // 회원가입 함수
        async register() {
            try {
                // 서버에 회원가입 요청
                await axios.post("http://127.0.0.1:8000/api/register",{
                    userId: this.userId,
                    username: this.username,
                    email: this.email,
                    password: this.password,
                    password_confirmation: this.password_confirmation,

                });
                // 회원가입 성공시
                alert("회원가입 성공 로그인 해주세요");
                // 로그인 페이지로 이동
                this.$router.push({ name: "Login"});
            } catch (error) {
                // 회원가입 실패
                alert("회원가입 실패");
            }
        },
    },
};
</script>
