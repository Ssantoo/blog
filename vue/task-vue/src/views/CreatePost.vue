//글 작성페이지
<template>
    <div>
        <h1>글 쓰기</h1>
        <!--글 작성 양식-->
        <form @submit.prevent="createPost">
            <div>
                <label for="title">제목:</label>
                <input id="title" v-model="title" placeholder="제목을 입력해주세요."/>
            </div>
            <div>
                <lavel for="content">내용:</lavel>
                <textarea id="content" v-model="content" placeholder="작성자를 입력해주세요."></textarea>
            </div>
            <!-- 글 작성 버튼 -->
            <button type="submit">글쓰기</button>
            <button @click="goToBack">뒤로가기</button>
        </form>
    </div>
</template>

<script>
import api from "@/utils/api.js";

export default{
    name: "CreatePost",
    data() {
        return {
            title: "",
            content: "",
        };
    },
    methods: {
        // 뒤로 가기 버튼 클릭 시 게시글 목록 페이지로 이동
        goToBack() {
            this.$router.push({ name: "Posts" });
        },
        //글 작성 API를 호출하여 게시글을 생성
        async createPost() {
            if (!this.submitDisabled) {
                try {
                    const response = await api.post("http://192.168.20.10:8000/api/post", {
                        title: this.title,
                        content: this.content,
                    });
                    console.log(response.data);
                    //글 작성 완료되면
                    console.log("글 작성 완료");
                    //작성된 게시글로 이동
                    this.$router.push({ name: "ViewPost", params: { postId: response.data.post.id } });
                } catch (error) {
                    console.error(error);
                }
            } else {
                console.log("제목 또는 글 내용이 비었습니다.");
            }
        },
        //제목과 내용이 모두 입력되었는지 확인
        checkFormValidity() {
            this.submitDisabled = !this.title.trim() || !this.content.trim();
        },
    },
};

</script>