#!/bin/bash

# Script de test pour l'API Social Network
BASE_URL="http://localhost:8080"

echo "=== Test de l'API Social Network ==="
echo ""

echo "1. Test GET /users"
curl -s "$BASE_URL/users" | head -c 200
echo ""
echo ""

echo "2. Test GET /users/count"
curl -s "$BASE_URL/users/count"
echo ""
echo ""

echo "3. Test POST /users"
curl -s -X POST -H "Content-Type: application/json" -d '{"username": "testuser", "email": "test@example.com", "password": "test123"}' "$BASE_URL/users"
echo ""
echo ""

echo "4. Test GET /posts/count"
curl -s "$BASE_URL/posts/count"
echo ""
echo ""

echo "5. Test GET /posts/last-five"
curl -s "$BASE_URL/posts/last-five" | head -c 200
echo ""
echo ""

echo "6. Test GET /users/usernames?page=1"
curl -s "$BASE_URL/users/usernames?page=1"
echo ""
echo ""

echo "=== Tests terminés ==="

