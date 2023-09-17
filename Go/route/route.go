package route

import (
	"log"
	"net/http"
	"runtime"

	"github.com/arfan21/bookingtogo/customer/customerctrl"
	"github.com/arfan21/bookingtogo/customer/customerrepo"
	"github.com/arfan21/bookingtogo/customer/customerusecase"
	"github.com/arfan21/bookingtogo/family/familydomain"
	"github.com/arfan21/bookingtogo/family/familyrepo"
	"github.com/arfan21/bookingtogo/family/familyusecase"
	"github.com/gorilla/mux"
	"github.com/jackc/pgx/v5/pgxpool"
)

func Setup(r *mux.Router, db *pgxpool.Pool) {
	middlewareRecover(r)
	family := initializeFamily(r, db)
	initializeCustomer(r, db, family)
}

func initializeCustomer(r *mux.Router, db *pgxpool.Pool, family familydomain.Usecase) {
	repo := customerrepo.New(db)
	svc := customerusecase.New(repo, family)
	ctrl := customerctrl.New(svc)

	r.HandleFunc("/customer/{id}", ctrl.GetCustomerById).Methods("GET")
	r.HandleFunc("/customer", ctrl.GetCustomerList).Methods("GET")
}

func initializeFamily(r *mux.Router, db *pgxpool.Pool) familydomain.Usecase {
	repo := familyrepo.New(db)
	svc := familyusecase.New(repo)
	return svc
}

func middlewareRecover(r *mux.Router) {
	r.Use(func(next http.Handler) http.Handler {
		return http.HandlerFunc(func(w http.ResponseWriter, r *http.Request) {
			defer func() {

				if err := recover(); err != nil {
					log.Println("panic:", err)
					stack := make([]byte, 1024*8)
					stack = stack[:runtime.Stack(stack, false)]
					log.Println(string(stack))
					w.Header().Set("Content-Type", "application/json")
					w.WriteHeader(http.StatusInternalServerError)
					w.Write([]byte(`{"message": "Internal Server Error"}`))
				}
			}()

			next.ServeHTTP(w, r)
		})
	})
}
