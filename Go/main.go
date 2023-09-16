package main

import (
	"context"
	"log"
	"net/http"
	"os"

	"github.com/arfan21/bookingtogo/config/configpg"
	"github.com/arfan21/bookingtogo/route"
	"github.com/gorilla/mux"

	_ "github.com/joho/godotenv/autoload"
)

func main() {
	r := mux.NewRouter()
	db, err := configpg.New(context.Background())
	if err != nil {
		panic(err)

	}
	route.Setup(r, db)

	port := "8080"
	if os.Getenv("PORT") != "" {
		port = os.Getenv("PORT")
	}

	log.Println("Server running on http://localhost:" + port)
	http.ListenAndServe(":"+port, r)
}
