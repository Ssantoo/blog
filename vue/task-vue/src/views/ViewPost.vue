//글 보기 페이지
<template>
    <div>
      <h1>상세보기</h1>
      <div v-if="post">
        <h4>{{ post.id }}</h4>
      </div>  
      <table>
        <thead>
          <tr>
            <th>제목</th>
            <th>글내용</th>
            <th>글쓴이</th>
          </tr>
        </thead>
        <tbody>
          <!-- 선택한 게시물의 정보를 보여줍니다. -->
          <tr v-if="post">
            <td>{{ post.title }}</td>
            <td>{{ post.content }}</td>
            <td>{{ post.username }}</td>
          </tr>
        </tbody>
      </table>
      <!-- 현재 로그인한 사용자가 게시물 작성자일 경우 수정 및 삭제 버튼이 보입니다. -->
      <button v-if="post !== null && currentUserId !== null && currentUserId === post.user_id" @click="goToUpdatePost(post.id)">수정</button>
      <button v-if="post !== null && currentUserId !== null && currentUserId === post.user_id" @click="deletePost(post.id)">삭제</button>
      <button @click="goToPostList">목록</button>
    </div>
</template>
  
<script>
import api from "@/utils/api.js";
import store from "@/store.js";

export default {
    name: "ViewPost",
    props: {
      postId: {
        type: String,
        required: true,
      },
    },
    data() {
      return {
        post: null,
      };
    },
    methods: {
        // 수정 페이지로 이동하는 함수
        goToUpdatePost(postId){
            this.$router.push({ name: "EditPost", params: {postId: postId }});
        },
        // 게시물 목록 페이지로 이동하는 함수
        goToPostList(){
            this.$router.push({ name:"Posts" });
        },
        // 게시물을 삭제하는 함수
        async deletePost(postId){
            try {
                await api.delete(`http://127.0.0.1:8000/api/post/${this.postId}`)
                alert('삭제 완료');
                this.$router.push({ name:"Posts"});
            } catch (error) {
                alert("작성자만 삭제할 수 있습니다.");
            }
        }
    },
    // 컴포넌트가 마운트 되었을 때 선택한 게시물의 정보를 가져옵니다.
    async mounted() {
        try {
            const response = await api.get(`/post/${this.postId}`);
            this.post = response.data;
        } catch (error) {
            console.error(error);
        }
    },
    // 현재 로그인한 사용자의 ID를 가져옵니다.
    computed: {
        currentUserId() {
            const userId = store.getters.currentUserId.value;
            return userId;
        },
    },
};
</script>
  
<style scoped>
    table {
        width: 50%;
        border-collapse: collapse;
        margin-left: auto;
        margin-right: auto;
    }
    th, td {
        text-align: center;
        border: 1px solid #ccc;
        padding: 8px;
    }
</style>
