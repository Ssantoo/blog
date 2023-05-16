import { reactive, computed } from "vue";
//import jwt_decode from "jwt-decode";

// 상태 관리를 위한 state 객체
const state = reactive({
    user: null,
});

// getters 객체 정의
const getters = {
    isLoggedIn: computed(() => state.user !== null),
    currentUser: computed(() => state.user),
    currentUserId: computed(() => {
       // 로컬 스토리지에서 user-id를 가져온다.
        const userId = localStorage.getItem("userId");
        return userId ? parseInt(userId, 10) : null;
    }),
};

// 상태를 수정하는 mutations 객체 정의
const mutations = {
    setUser(user) {
        state.user = user;
        if (user) {
            localStorage.setItem("userId", user.id);
        } else {
            localStorage.removeItem("userId");
        }
    },
};

// store 객체 내보내기
export default {
    state,
    getters,
    mutations,
}
