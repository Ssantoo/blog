//글 수정 페이지
<template>
    <div>
        <h1>글 수정</h1>
        <!-- 글 수정 양식 -->
        <form @submit.prevent="updatePost">
        <div>
            <label for="title">제목:</label>
            <input type="text" id="title" v-model="title" />
        </div>
        <div>
            <label for="content">내용:</label>
            <textarea id="content" v-model="content"></textarea>
        </div>
        <button type="submit">수정하기</button>
        <button @click="goToBack">뒤로가기</button>
        </form>
    </div>
</template>

<script>
import api from '@/utils/api.js';

export default {
  name: "EditPost",
  props: {
    // 수정할 게시글 ID를 받음
    postId: {
        type: String,
        required: true,
    },
  },
  data() {
    return {
      title: "",
      content: "",
    };
  },
  methods: {
    // 수정된 게시글 내용을 API로 전송하여 업데이트
    async updatePost() {
      try {
        const response = await api.patch(`http://127.0.0.1:8000/api/post/${this.postId}`, {
          title: this.title,
          content: this.content,
        });
        console.log(response.data);
        alert('수정 완료');
        this.$router.push({ name: "Posts"});
      } catch (error) {
          console.error(error);
          alert('게시물 수정 실패 다시 시도해주세요');
        }
      },
    },
    async mounted() {
        try {
            // 수정할 게시물 정보를 가져옴
            const response = await api.get(`/post/${this.postId}`);
            const post = response.data;
            
            console.log(post, "뭐가오니?");

            //게시물 정보를 가져오기
            this.title = post.title;
            this.content = post.content;
        } catch (error) {
            console.log(error);
            alert('게시글 존재하지 않거나 게시글이 유효하지 않습니다.');
            this.$route.push({ name: "Posts" });
        }
    },
  };
</script>
