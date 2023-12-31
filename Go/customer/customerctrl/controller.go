package customerctrl

import (
	"encoding/json"
	"log"
	"net/http"
	"strconv"

	"github.com/arfan21/bookingtogo/customer/customerdomain"
	"github.com/gorilla/mux"
)

type Controller struct {
	usecase customerdomain.Usecase
}

func New(usecase customerdomain.Usecase) *Controller {
	return &Controller{usecase: usecase}
}

func (c *Controller) GetCustomerById(w http.ResponseWriter, r *http.Request) {
	w.Header().Set("Content-Type", "application/json")
	vars := mux.Vars(r)
	idStr := vars["id"]
	id, err := strconv.Atoi(idStr)
	if err != nil {
		log.Println(err)
		http.Error(w, err.Error(), http.StatusBadRequest)

		return
	}

	res, err := c.usecase.GetCustomerById(r.Context(), id)
	if err != nil {
		log.Println(err)
		http.Error(w, err.Error(), http.StatusInternalServerError)

		return
	}

	w.WriteHeader(http.StatusOK)
	resJSON, err := json.Marshal(&res)
	if err != nil {
		log.Println(err)
		http.Error(w, err.Error(), http.StatusInternalServerError)

		return
	}

	w.Write(resJSON)

}

func (c *Controller) GetCustomerList(w http.ResponseWriter, r *http.Request) {
	w.Header().Set("Content-Type", "application/json")

	res, err := c.usecase.GetCustomerList(r.Context())
	if err != nil {
		log.Println(err)
		http.Error(w, err.Error(), http.StatusInternalServerError)

		return
	}

	w.WriteHeader(http.StatusOK)
	resJSON, err := json.Marshal(&res)
	if err != nil {
		log.Println(err)
		http.Error(w, err.Error(), http.StatusInternalServerError)

		return
	}

	w.Write(resJSON)
}
