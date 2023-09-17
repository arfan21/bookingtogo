package customerusecase

import (
	"context"
	"fmt"

	"github.com/arfan21/bookingtogo/customer/customerdomain"
	"github.com/arfan21/bookingtogo/family/familydomain"
)

type usecase struct {
	repo   customerdomain.Repository
	family familydomain.Usecase
}

func New(repo customerdomain.Repository, family familydomain.Usecase) customerdomain.Usecase {
	return &usecase{repo: repo, family: family}
}

func (u *usecase) GetCustomerById(ctx context.Context, id int) (res customerdomain.CustomerResponse, err error) {
	familyList, err := u.family.GetFamilyByCstID(ctx, id)
	if err != nil {
		err = fmt.Errorf("customerusecase: error when get family by cst_id: %w", err)
		return
	}

	dbResult, err := u.repo.GetCustomerById(ctx, id)
	if err != nil {
		err = fmt.Errorf("customerusecase: error when get customer by id: %w", err)
		return
	}

	res.FromDB(dbResult)
	res.Family = familyList

	return
}

func (u *usecase) GetCustomerList(ctx context.Context) (res []customerdomain.CustomerListResponse, err error) {
	dbResult, err := u.repo.GetCustomerList(ctx)
	if err != nil {
		err = fmt.Errorf("customerusecase: error when get customer list: %w", err)
		return
	}

	for _, v := range dbResult {
		var customer customerdomain.CustomerListResponse
		customer.FromDB(v)
		res = append(res, customer)
	}

	return
}
