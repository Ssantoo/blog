<template>
    <header v-if="showHeader">
       <!-- 로고 이미지를 클릭하면 게시물 목록으로 이동-->
        <img
          src="@/assets/logo.png"
          alt="Vue logo"
          class="logo"
          @click="goToPostsList"
        />
      <div class="header-content">
        <!-- 로그인한 경우, 사용자 이름과 로그아웃 버튼을 표시-->
        <span v-if="isLoggedIn">
          {{ currentUser  }} 님
          <div>
          <button @click="logout">로그아웃</button>
          <!-- <button @click="goToMyPosts">내 게시물</button> -->
        </div>
        </span>
        
      </div>
    </header>
  </template>
  
  <script>
  import jwt_decode from "jwt-decode";
  
  export default {
    name: "AppHeader",
    data() {
      return {
        loggedIn: false,
        username: "",
      };
    },
    methods: {
      //로그아웃 기능 구현
      logout() {
        localStorage.removeItem("user-token");
        this.$router.push({ name: "Login" });
        location.reload();
      },
      //내 게시물 페이지로 이동
      goToMyPosts() {
        this.$router.push({ name: "MyPosts" });
      },
      //게시물 목록 페이지로 이동
      goToPostsList() {
        this.$router.replace({ name: "Posts", query: { page: 1 } });
      },
    },
    //컴포넌트 생성 시, 로컬 스토리지에서 토큰을 확인하고 사용자 이름을 가져옴
    created() {
      const token = localStorage.getItem("user-token");
      if (token) {
        try {
          const decoded = jwt_decode(token);
          this.loggedIn = true;
          this.username = decoded.username;
            // console.log("뭐뜨니", decoded.username);
        } catch (e) {
          console.error("토큰x:", e);
        }
      }
    },
    computed: {
      //로그인 및 회원가입 페이지에서 헤더를 숨기기 위한 조건
    showHeader() {
      return !["Login", "Register"].includes(this.$route.name);
    },
    //로그인 여부를 확인하는 computed 속성
    isLoggedIn() {
      const token = localStorage.getItem("user-token");
      if (token) {
        try {
          jwt_decode(token);
          return true;
        } catch (e) {
          console.error("토큰x:", e);
        }
      }
      return false;
    },

    //현재 로그인한 사용자의 이름을 반환하는 computed속성
    currentUser() {
        if (this.isLoggedIn) {
            const token = localStorage.getItem("user-token");
            const username = localStorage.getItem("username");
            const decoded = jwt_decode(token);

            console.log("decoded token:", decoded);

            return username;
        }
        return "";
    },
  },
};
  </script>
  
  <style scoped>
  .header-content {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 1rem;
  }
  .logo {
    width: 100px;
    height: 100px;
    cursor: pointer;
  }
  </style>