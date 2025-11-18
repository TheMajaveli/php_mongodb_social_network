#!/bin/bash

# Comprehensive API Test Script
BASE_URL="http://localhost:8080"
GREEN='\033[0;32m'
RED='\033[0;31m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

# Variables to store created IDs
USER_ID=""
POST_ID=""
CATEGORY_ID=""
COMMENT_ID=""
LIKE_ID=""
FOLLOW_ID=""

test_count=0
pass_count=0
fail_count=0

# Helper function to print test results
print_test() {
    test_count=$((test_count + 1))
    echo -e "${YELLOW}Test $test_count: $1${NC}"
}

print_pass() {
    pass_count=$((pass_count + 1))
    echo -e "${GREEN}✓ PASS${NC}"
}

print_fail() {
    fail_count=$((fail_count + 1))
    echo -e "${RED}✗ FAIL${NC}"
}

# Helper function to make API calls
api_call() {
    method=$1
    endpoint=$2
    data=$3
    expected_status=${4:-200}
    
    if [ -n "$data" ]; then
        response=$(curl -s -w "\n%{http_code}" -X "$method" \
            -H "Content-Type: application/json" \
            -d "$data" \
            "$BASE_URL$endpoint")
    else
        response=$(curl -s -w "\n%{http_code}" -X "$method" \
            "$BASE_URL$endpoint")
    fi
    
    http_code=$(echo "$response" | tail -n1)
    body=$(echo "$response" | sed '$d')
    
    if [ "$http_code" -eq "$expected_status" ]; then
        print_pass
        echo "$body" | head -c 200
        echo ""
        echo "$body"
        return 0
    else
        print_fail
        echo "Expected status: $expected_status, Got: $http_code"
        echo "$body"
        return 1
    fi
}

echo "=========================================="
echo "  Comprehensive API Test Suite"
echo "=========================================="
echo ""

# ============================================
# USERS TESTS
# ============================================
echo "=== USERS ENDPOINTS ==="
echo ""

print_test "GET /users (list all users)"
api_call "GET" "/users" "" 200
echo ""

print_test "GET /users?page=2 (pagination)"
api_call "GET" "/users?page=2" "" 200
echo ""

print_test "GET /users/count"
api_call "GET" "/users/count" "" 200
echo ""

print_test "GET /users/usernames?page=1"
api_call "GET" "/users/usernames?page=1" "" 200
echo ""

print_test "POST /users (create user)"
response=$(curl -s -X POST -H "Content-Type: application/json" \
    -d '{"username": "testuser_'$(date +%s)'", "email": "test'$(date +%s)'@example.com", "password": "test123"}' \
    "$BASE_URL/users")
if echo "$response" | grep -q "success"; then
    print_pass
    USER_ID=$(echo "$response" | grep -o '"_id":"[^"]*' | head -1 | cut -d'"' -f4)
    echo "Created user ID: $USER_ID"
    echo "$response" | head -c 200
    echo ""
else
    print_fail
    echo "$response"
fi
echo ""

if [ -n "$USER_ID" ]; then
    print_test "GET /users/{id} (get user by ID)"
    api_call "GET" "/users/$USER_ID" "" 200
    echo ""
    
    print_test "PUT /users/{id} (update user)"
    api_call "PUT" "/users/$USER_ID" '{"username": "updated_user"}' 200
    echo ""
fi

# ============================================
# CATEGORIES TESTS
# ============================================
echo "=== CATEGORIES ENDPOINTS ==="
echo ""

print_test "GET /categories (list all categories)"
api_call "GET" "/categories" "" 200
echo ""

print_test "POST /categories (create category)"
response=$(curl -s -X POST -H "Content-Type: application/json" \
    -d '{"name": "Test Category '$(date +%s)'"}' \
    "$BASE_URL/categories")
if echo "$response" | grep -q "success"; then
    print_pass
    CATEGORY_ID=$(echo "$response" | grep -o '"_id":"[^"]*' | head -1 | cut -d'"' -f4)
    echo "Created category ID: $CATEGORY_ID"
    echo "$response" | head -c 200
    echo ""
else
    print_fail
    echo "$response"
fi
echo ""

if [ -n "$CATEGORY_ID" ]; then
    print_test "GET /categories/{id} (get category by ID)"
    api_call "GET" "/categories/$CATEGORY_ID" "" 200
    echo ""
    
    print_test "PUT /categories/{id} (update category)"
    api_call "PUT" "/categories/$CATEGORY_ID" '{"name": "Updated Category"}' 200
    echo ""
fi

# ============================================
# POSTS TESTS
# ============================================
echo "=== POSTS ENDPOINTS ==="
echo ""

print_test "GET /posts (list all posts)"
api_call "GET" "/posts" "" 200
echo ""

print_test "GET /posts/count"
api_call "GET" "/posts/count" "" 200
echo ""

print_test "GET /posts/last-five"
api_call "GET" "/posts/last-five" "" 200
echo ""

print_test "GET /posts/without-comments"
api_call "GET" "/posts/without-comments" "" 200
echo ""

print_test "GET /posts/search?word=technologie"
api_call "GET" "/posts/search?word=technologie" "" 200
echo ""

print_test "GET /posts/before-date?date=2024-12-01"
api_call "GET" "/posts/before-date?date=2024-12-01" "" 200
echo ""

print_test "GET /posts/after-date?date=2024-01-01"
api_call "GET" "/posts/after-date?date=2024-01-01" "" 200
echo ""

print_test "POST /posts (create post)"
response=$(curl -s -X POST -H "Content-Type: application/json" \
    -d '{"content": "Test post content '$(date +%s)'", "category_id": 1, "user_id": 1}' \
    "$BASE_URL/posts")
if echo "$response" | grep -q "success"; then
    print_pass
    POST_ID=$(echo "$response" | grep -o '"_id":"[^"]*' | head -1 | cut -d'"' -f4)
    echo "Created post ID: $POST_ID"
    echo "$response" | head -c 200
    echo ""
else
    print_fail
    echo "$response"
fi
echo ""

if [ -n "$POST_ID" ]; then
    print_test "GET /posts/{id} (get post by ID)"
    api_call "GET" "/posts/$POST_ID" "" 200
    echo ""
    
    print_test "GET /posts/{id}/comments (get post with comments)"
    api_call "GET" "/posts/$POST_ID/comments" "" 200
    echo ""
    
    print_test "PUT /posts/{id} (update post)"
    api_call "PUT" "/posts/$POST_ID" '{"content": "Updated post content"}' 200
    echo ""
fi

# ============================================
# COMMENTS TESTS
# ============================================
echo "=== COMMENTS ENDPOINTS ==="
echo ""

print_test "GET /comments (list all comments)"
api_call "GET" "/comments" "" 200
echo ""

if [ -n "$POST_ID" ]; then
    print_test "GET /comments/count?post_id={id}"
    api_call "GET" "/comments/count?post_id=$POST_ID" "" 200
    echo ""
    
    print_test "POST /comments (create comment)"
    response=$(curl -s -X POST -H "Content-Type: application/json" \
        -d "{\"content\": \"Test comment $(date +%s)\", \"user_id\": 1, \"post_id\": \"$POST_ID\"}" \
        "$BASE_URL/comments")
    if echo "$response" | grep -q "success"; then
        print_pass
        COMMENT_ID=$(echo "$response" | grep -o '"_id":"[^"]*' | head -1 | cut -d'"' -f4)
        echo "Created comment ID: $COMMENT_ID"
        echo "$response" | head -c 200
        echo ""
    else
        print_fail
        echo "$response"
    fi
    echo ""
    
    if [ -n "$COMMENT_ID" ]; then
        print_test "GET /comments/{id} (get comment by ID)"
        api_call "GET" "/comments/$COMMENT_ID" "" 200
        echo ""
        
        print_test "PUT /comments/{id} (update comment)"
        api_call "PUT" "/comments/$COMMENT_ID" '{"content": "Updated comment"}' 200
        echo ""
    fi
fi

# ============================================
# LIKES TESTS
# ============================================
echo "=== LIKES ENDPOINTS ==="
echo ""

print_test "GET /likes (list all likes)"
api_call "GET" "/likes" "" 200
echo ""

print_test "GET /likes/average?category_id=1"
api_call "GET" "/likes/average?category_id=1" "" 200
echo ""

if [ -n "$POST_ID" ]; then
    print_test "POST /likes (create like)"
    response=$(curl -s -X POST -H "Content-Type: application/json" \
        -d "{\"post_id\": \"$POST_ID\", \"user_id\": 1}" \
        "$BASE_URL/likes")
    if echo "$response" | grep -q "success"; then
        print_pass
        LIKE_ID=$(echo "$response" | grep -o '"_id":"[^"]*' | head -1 | cut -d'"' -f4)
        echo "Created like ID: $LIKE_ID"
        echo "$response" | head -c 200
        echo ""
    else
        print_fail
        echo "$response"
    fi
    echo ""
    
    if [ -n "$LIKE_ID" ]; then
        print_test "GET /likes/{id} (get like by ID)"
        api_call "GET" "/likes/$LIKE_ID" "" 200
        echo ""
    fi
fi

# ============================================
# FOLLOWS TESTS
# ============================================
echo "=== FOLLOWS ENDPOINTS ==="
echo ""

print_test "GET /follows (list all follows)"
api_call "GET" "/follows" "" 200
echo ""

print_test "GET /follows/following-count?user_id=1"
api_call "GET" "/follows/following-count?user_id=1" "" 200
echo ""

print_test "GET /follows/followers-count?user_id=1"
api_call "GET" "/follows/followers-count?user_id=1" "" 200
echo ""

print_test "GET /follows/top-three"
api_call "GET" "/follows/top-three" "" 200
echo ""

print_test "POST /follows (create follow)"
response=$(curl -s -X POST -H "Content-Type: application/json" \
    -d '{"user_id": 1, "user_follow_id": 2}' \
    "$BASE_URL/follows")
if echo "$response" | grep -q "success"; then
    print_pass
    FOLLOW_ID=$(echo "$response" | grep -o '"_id":"[^"]*' | head -1 | cut -d'"' -f4)
    echo "Created follow ID: $FOLLOW_ID"
    echo "$response" | head -c 200
    echo ""
else
    print_fail
    echo "$response"
fi
echo ""

if [ -n "$FOLLOW_ID" ]; then
    print_test "GET /follows/{id} (get follow by ID)"
    api_call "GET" "/follows/$FOLLOW_ID" "" 200
    echo ""
fi

# ============================================
# DELETE TESTS (cleanup)
# ============================================
echo "=== CLEANUP (DELETE) ==="
echo ""

if [ -n "$FOLLOW_ID" ]; then
    print_test "DELETE /follows/{id}"
    api_call "DELETE" "/follows/$FOLLOW_ID" "" 200
    echo ""
fi

if [ -n "$LIKE_ID" ]; then
    print_test "DELETE /likes/{id}"
    api_call "DELETE" "/likes/$LIKE_ID" "" 200
    echo ""
fi

if [ -n "$COMMENT_ID" ]; then
    print_test "DELETE /comments/{id}"
    api_call "DELETE" "/comments/$COMMENT_ID" "" 200
    echo ""
fi

if [ -n "$POST_ID" ]; then
    print_test "DELETE /posts/{id}"
    api_call "DELETE" "/posts/$POST_ID" "" 200
    echo ""
fi

if [ -n "$CATEGORY_ID" ]; then
    print_test "DELETE /categories/{id}"
    api_call "DELETE" "/categories/$CATEGORY_ID" "" 200
    echo ""
fi

if [ -n "$USER_ID" ]; then
    print_test "DELETE /users/{id}"
    api_call "DELETE" "/users/$USER_ID" "" 200
    echo ""
fi

# ============================================
# SUMMARY
# ============================================
echo "=========================================="
echo "  Test Summary"
echo "=========================================="
echo "Total tests: $test_count"
echo -e "${GREEN}Passed: $pass_count${NC}"
echo -e "${RED}Failed: $fail_count${NC}"
echo ""

if [ $fail_count -eq 0 ]; then
    echo -e "${GREEN}All tests passed! ✓${NC}"
    exit 0
else
    echo -e "${RED}Some tests failed. Please review the output above.${NC}"
    exit 1
fi

