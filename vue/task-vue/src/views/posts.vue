//게시판의 게시물 목록
<template>
    <div>
      <h1>게시판</h1>
      <table>
        <thead>
          <tr>
            <th>글번호</th>
            <th>제목</th>
            <th>글내용</th>
            <th>글쓴이</th>
          </tr>
        </thead>
        <tbody>
          <!-- 게시물 목록을 순회하며 출력 -->
          <tr v-for="post in posts" :key="post.id" @click="goToViewPost(post.id)">
            <td>{{ post.id }}</td>
            <td>{{ post.title }}</td>
            <td>{{ post.content }}</td>
            <td>{{ post.username }}</td>
          </tr>
        </tbody>
      </table>
      <div class="pagination">
        <!-- 페이지네이션 버튼 -->
        <button @click="prePage" :disabled="currentPage === 1">&lt;</button>
        <button
        v-for="page in lastPage"
        :key="page"
        @click="getPosts(page)"
        :class="{ active: currentPage === page}"
        >
            {{ page }}
        </button>
        <button @click="nextPage" :disabled="currentPage === lastPage">&gt;</button>
        <div>
            <!-- 글쓰기 버튼 -->
            <button @click="goToWritePost">글쓰기</button>
        </div>
      </div>
    </div>
</template>
  

<script>
import api from '@/utils/api.js';

export default {
    name: "PostsList",
    data() {
        return {
            posts: [],
            currentPage: 1,
            lastPage: null,
        };
    },
    methods: {
        // 글쓰기 페이지로 이동
        goToWritePost(){
            this.$router.push({ name: "CreatePost" });
        },
        // 게시물 보기 페이지로 이동
        goToViewPost(postId){
            this.$router.push({ name: "ViewPost", params: {postId: postId } });
        },
        // 이전 페이지로 이동
        prePage() {
            if (this.currentPage > 1) {
                this.getPosts(this.currentPage -1);
            }
        },
        // 다음 페이지로 이동
        nextPage() {
            if (this.currentPage < this.lastPage) {
                this.getPosts(this.currentPage + 1); 
            }
        }, 
        // 페이지별 게시물 목록 가져오기
        async getPosts(page) {
            try {
                const response = await api.get("/posts", {params: { page }});
                this.posts = response.data.data;
                this.currentPage = response.data.current_page;
                this.lastPage = response.data.last_page;
            } catch (error) {
                console.error("게시물 불러오기 오류", error);
            }
        },
    },
    // 페이지가 생성되면 게시물 목록 가져오기
    created() {
        const page = parseInt(this.$route.query.page) || 1;
        this.getPosts(page);
    },
    // 페이지 쿼리가 변경될 때마다 게시물 목록 업데이트
    watch: {
        '$route.query.page': {
            immediate: true,
            handler(newVal, oldVal) {
                if (newVal !== oldVal){
                const page = parseInt(newVal) || 1;
                this.getPosts(page);
                }
            },
        },
    },
};