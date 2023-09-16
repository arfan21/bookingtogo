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

	res, err = u.repo.GetCustomerById(ctx, id)
	if err != nil {
		err = fmt.Errorf("customerusecase: error when get customer by id: %w", err)
		return
	}
	res.Family = familyList

	return
}
