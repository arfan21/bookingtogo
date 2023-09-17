package familyusecase

import (
	"context"
	"fmt"

	"github.com/arfan21/bookingtogo/family/familydomain"
)

type usecase struct {
	repo familydomain.Repository
}

func New(repo familydomain.Repository) familydomain.Usecase {
	return &usecase{repo: repo}
}

func (u *usecase) GetFamilyByCstID(ctx context.Context, cstID int) (res []familydomain.FamilyResponse, err error) {
	resultDB, err := u.repo.GetFamilyByCstID(ctx, cstID)
	if err != nil {
		err = fmt.Errorf("familyusecase: error when get family by cst_id: %w", err)
		return
	}

	if len(resultDB) == 0 {
		res = make([]familydomain.FamilyResponse, 0)
	}

	for _, v := range resultDB {
		var family familydomain.FamilyResponse
		family.FromDB(v)
		res = append(res, family)
	}

	return
}
